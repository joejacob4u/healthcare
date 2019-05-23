<?php

namespace App\Http\Controllers\Frontend\Tracer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tracer\Section;
use App\Tracer\Tracer;
use App\Regulatory\BuildingDepartment;
use App\User;
use App\Equipment\Equipment;
use App\Regulatory\Room;
use App\Tracer\QuestionEvaluation;
use Storage;
use App\Regulatory\Building;
use App\Regulatory\EOPFinding;
use App\Tracer\Question;

class TracerController extends Controller
{
    public function __construct()
    {
        return $this->middleware('user');
    }

    public function index()
    {
        $tracers = Tracer::where('building_id', session('building_id'))->orderByDesc('created_at')->paginate(15);
        return view('tracer.index', ['tracers' => $tracers]);
    }

    public function create()
    {
        $departments = BuildingDepartment::where('building_id', session('building_id'))->pluck('name', 'id');
        $tracer_sections = Section::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('tracer.add', ['departments' => $departments, 'tracer_sections' => $tracer_sections, 'users' => $users]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'building_department_id' => 'required',
            'tracer_section_id' => 'required',
            'tracer_checklist_type_id' => 'required'
        ]);

        if (Tracer::create($request->all())) {
            return redirect('/tracers')->with('success', 'New tracer created.');
        }
    }

    public function evaluate(Tracer $tracer)
    {
        $equipments = Equipment::where('building_id', session('building_id'))->get();
        $building = Building::find(session('building_id'));

        $inventories = [];

        foreach ($equipments as $equipment) {
            foreach ($equipment->inventories as $inventory) {
                $inventories[$inventory->id] = $inventory;
            }
        }

        $rooms = Room::where('building_department_id', $tracer->department->id)->pluck('room_number', 'id');
        return view('tracer.evaluate', ['tracer' => $tracer, 'rooms' => $rooms, 'inventories' => $inventories, 'building' => $building]);
    }

    public function saveFinding(Request $request, Tracer $tracer)
    {
        if ($finding = QuestionEvaluation::create([
            'tracer_id' => $request->tracer_id,
            'question_id' => $request->question_id,
            'user_id' => $request->user_id,
            'finding' => json_decode($request->finding, true),
        ])) {
            $is_finding_complete = false;
            $finding_data = json_decode($request->finding, true);
            $files = Storage::disk('s3')->files($finding_data['attachment']);

            if ($tracer->status->id == 1) {
                $tracer->update(['tracer_status_id' => 2]);
            }

            if ($this->isFindingComplete($tracer)) {
                $is_finding_complete = true;
                $tracer->update(['tracer_status_id' => 3]);
            }

            return response()->json(['finding' => $finding, 'no_of_files' => count($files), 'files' => $files, 'is_finding_complete' => $is_finding_complete, 'question' => $finding->question]);
        }
    }

    public function verify(Request $request)
    {
        $tracer = Tracer::find($request->tracer_id);
        $is_compliant = true;

        foreach ($tracer->checklistType->categories as $category) {
            foreach ($category->questions as $question) {

                if ($question->work_order_problem_id == 0) {
                    //create an eop finding

                    $findings = $question->evaluations($tracer->id);

                    //lets do non-inventory first
                    if (!empty($findings['non_inventory'])) {
                        $is_compliant = false;
                        $data = [];
                        $data['inventory_id'] = '';
                        $data['accreditation_id'] = $findings['non_inventory']['accreditation_id'];
                        $data['comment'] = implode(',', $findings['non_inventory']['comment']);
                        $data['attachment_dir'] = '/finding/' . $tracer->user->id . '/' . $question->id . '/noninventory/' . time() . '/';
                        $data['rooms'] = $findings['non_inventory']['rooms'];

                        foreach ($findings['non_inventory']['attachment'] as $attachment) {
                            foreach (Storage::disk('s3')->files($attachment) as $file) {
                                Storage::disk('s3')->copy($file, $data['attachment_dir'] . basename($file));
                            }
                        }

                        //create work order
                        $this->createEOPFinding($tracer, $question, $data);
                    }
                } else {
                    //create a work order

                    $findings = $question->evaluations($tracer->id);

                    //lets do non-inventory first
                    if (!empty($findings['non_inventory'])) {
                        $is_compliant = false;
                        $data = [];
                        $data['inventory_id'] = '';
                        $data['comment'] = implode(',', $findings['non_inventory']['comment']);
                        $data['attachment_dir'] = '/demand_work_orders/' . $tracer->user->id . '/' . $question->id . '/noninventory/' . time() . '/';
                        $data['rooms'] = $findings['non_inventory']['rooms'];

                        foreach ($findings['non_inventory']['attachment'] as $attachment) {
                            foreach (Storage::disk('s3')->files($attachment) as $file) {
                                Storage::disk('s3')->copy($file, $data['attachment_dir'] . basename($file));
                            }
                        }

                        //create work order
                        $this->createDemandWorkOrder($tracer, $question, $data);
                    }

                    //lets do one with inventory next

                    if (!empty($findings['inventories'])) {
                        foreach ($findings['inventories'] as $inventory_id => $inventory) {
                            $is_compliant = false;
                            $data = [];
                            $data['inventory_id'] = $inventory_id;
                            $data['comment'] = implode(',', $inventory['comment']);
                            $data['attachment_dir'] = '/demand_work_orders/' . $tracer->user->id . '/' . $question->id . '/inventory/' . time() . '/';
                            $data['rooms'] = $inventory['rooms'];

                            foreach ($inventory['attachment'] as $attachment) {
                                foreach (Storage::disk('s3')->files($attachment) as $file) {
                                    Storage::disk('s3')->copy($file, $data['attachment_dir'] . basename($file));
                                }
                            }

                            //create work order
                            $this->createDemandWorkOrder($tracer, $question, $data);
                        }
                    }
                }
            }
        }



        //update rounding status
        $tracer->update(['tracer_status_id' => ($is_compliant) ? 4 : 5]);

        return back();
    }



    public function fetchChecklistTypes(Request $request)
    {
        $section = Section::find($request->tracer_section_id);
        return response()->json(['checklist_types' => $section->checklistTypes]);
    }

    private function isFindingComplete(Tracer $tracer)
    {
        foreach ($tracer->checklistType->categories as $category) {
            foreach ($category->questions as $question) {
                //has to be answerd and by a leader
                if ($tracer->evaluations->where('question_id', $question->id)->count() < 1) {
                    return false;
                }
            }
        }

        return true;
    }

    private function createDemandWorkOrder(Tracer $tracer, Question $question, $data)
    {
        $wo_data = [
            'requester_name' => $tracer->user->name,
            'requester_email' => $tracer->user->email,
            'hco_id' => session('hco_id'),
            'site_id' => session('site_id'),
            'building_id' => session('building_id'),
            'inventory_id' => (!empty($data['inventory_id'])) ? $data['inventory_id'] : 0,
            'building_department_id' => $tracer->department->id,
            'work_order_trade_id' => $question->trade->id,
            'work_order_problem_id' => $question->problem->id,
            'work_order_priority_id' => $question->problem->work_order_priority_id,
            'attachments_path' => $data['attachment_dir'],
            'comments' => $data['comment']
        ];

        if ($demand_work_order = DemandWorkOrder::create($wo_data)) {

            //add rooms to demand work order
            $demand_work_order->rooms()->sync($data['rooms']);
            //init ilsm for work order
            $demand_work_order->ilsmTracer()->create(['ilsm_tracer_status_id' => 8]);
            //link finding to work order
            $tracer->workOrders()->attach([$demand_work_order->id => ['tracer_question_id' => $question->id]]);
        }
    }

    private function createEOPFinding(Tracer $tracer, Question $question, $data)
    {
        $finding_data = [
            'accreditation_id' => $data['accreditation_id'][0],
            'accreditation_requirement_id' => $question->eop->standardLabel->accreditation_requirement_id,
            'building_id' => session('building_id'),
            'description' => $data['comment'],
            'plan_of_action' => '',
            'measure_of_success' => '',
            'measure_of_success_date' => '',
            'internal_notes' => '',
            'benefit' => '',
            'activity' => '',
            'department_id' => $tracer->department->id,
            'potential_to_cause_harm' => '',
            'is_policy_issue' => '',
            'eop_id' => $question->eop->id,
            'attachments_path' => $data['attachment_dir'],
            'documents_description' => '',
            'status' => 'initial',
            'created_by_user_id' => $tracer->user->id,
        ];

        if ($eop_finding = EOPFinding::create($finding_data)) {

            if (!empty($data['rooms'])) {
                $eop_finding->rooms()->sync($data['rooms']);
            }

            $tracer->eopFindings()->attach([$eop_finding->id => ['tracer_question_id' => $question->id]]);
        }
    }
}
