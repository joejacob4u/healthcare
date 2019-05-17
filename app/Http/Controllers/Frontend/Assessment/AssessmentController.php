<?php

namespace App\Http\Controllers\Frontend\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Assessment\Section;
use App\Assessment\Assessment;
use App\Regulatory\BuildingDepartment;
use App\User;
use App\Equipment\Equipment;
use App\Regulatory\Room;
use App\Assessment\QuestionEvaluation;
use Storage;
use App\Regulatory\Building;
use App\Regulatory\EOPFinding;

class AssessmentController extends Controller
{
    public function __construct()
    {
        return $this->middleware('user');
    }

    public function index()
    {
        $assessments = Assessment::where('building_id', session('building_id'))->orderByDesc('created_at')->paginate(15);
        return view('assessment.index', ['assessments' => $assessments]);
    }

    public function create()
    {
        $departments = BuildingDepartment::where('building_id', session('building_id'))->pluck('name', 'id');
        $assessment_sections = Section::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('assessment.add', ['departments' => $departments, 'assessment_sections' => $assessment_sections, 'users' => $users]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'building_department_id' => 'required',
            'assessment_section_id' => 'required',
            'assessment_checklist_type_id' => 'required'
        ]);

        if (Assessment::create($request->all())) {
            return redirect('/assessments')->with('success', 'New assessment created.');
        }
    }

    public function evaluate(Assessment $assessment)
    {
        $equipments = Equipment::where('building_id', session('building_id'))->get();
        $building = Building::find(session('building_id'));

        $inventories = [];

        foreach ($equipments as $equipment) {
            foreach ($equipment->inventories as $inventory) {
                $inventories[$inventory->id] = $inventory;
            }
        }

        $rooms = Room::where('building_department_id', $assessment->department->id)->pluck('room_number', 'id');
        return view('assessment.evaluate', ['assessment' => $assessment, 'rooms' => $rooms, 'inventories' => $inventories, 'building' => $building]);
    }

    public function saveFinding(Request $request, Assessment $assessment)
    {
        if ($finding = QuestionEvaluation::create([
            'assessment_id' => $request->assessment_id,
            'question_id' => $request->question_id,
            'user_id' => $request->user_id,
            'finding' => json_decode($request->finding, true),
        ])) {
            $is_finding_complete = false;
            $finding_data = json_decode($request->finding, true);
            $files = Storage::disk('s3')->files($finding_data['attachment']);

            if ($assessment->status->id == 1) {
                $assessment->update(['assessment_status_id' => 2]);
            }

            if ($this->isFindingComplete($assessment)) {
                $is_finding_complete = true;
                $assessment->update(['assessment_status_id' => 3]);
            }

            return response()->json(['finding' => $finding, 'no_of_files' => count($files), 'files' => $files, 'is_finding_complete' => $is_finding_complete, 'question' => $finding->question]);
        }
    }

    public function verify(Request $request)
    {
        $assessment = Assessment::find($request->assessment_id);
        $is_compliant = true;

        foreach ($assessment->checklistType->categories as $category) {
            foreach ($category->questions as $question) {

                if ($question->work_order_problem_id == 0) {
                    //create an eop finding

                    $findings = $question->evaluations($assessment->id);
                    dd($findings);

                    //lets do non-inventory first
                    if (!empty($findings['non_inventory'])) {
                        $is_compliant = false;
                        $data = [];
                        $data['inventory_id'] = '';
                        $data['accreditation_id'] = $findings['accreditation_id'];
                        $data['comment'] = implode(',', $findings['non_inventory']['comment']);
                        $data['attachment_dir'] = '/finding/' . $assessment->user->id . '/' . $question->id . '/noninventory/' . time() . '/';
                        $data['rooms'] = $findings['non_inventory']['rooms'];

                        foreach ($findings['non_inventory']['attachment'] as $attachment) {
                            foreach (Storage::disk('s3')->files($attachment) as $file) {
                                Storage::disk('s3')->copy($file, $data['attachment_dir'] . basename($file));
                            }
                        }

                        //create work order
                        $this->createEOPFinding($assessment, $question, $data);
                    }

                    //lets do one with inventory next

                    if (!empty($findings['inventories'])) {
                        foreach ($findings['inventories'] as $inventory_id => $inventory) {
                            $is_compliant = false;
                            $data = [];
                            $data['inventory_id'] = $inventory_id;
                            $data['accreditation_id'] = $findings['accreditation_id'];
                            $data['comment'] = implode(',', $inventory['comment']);
                            $data['attachment_dir'] = '/finding/' . $assessment->user->id . '/' . $question->id . '/inventory/' . time() . '/';
                            $data['rooms'] = $inventory['rooms'];

                            foreach ($inventory['attachment'] as $attachment) {
                                foreach (Storage::disk('s3')->files($attachment) as $file) {
                                    Storage::disk('s3')->copy($file, $data['attachment_dir'] . basename($file));
                                }
                            }

                            //create work order
                            $this->createEOPFinding($assessment, $question, $data);
                        }
                    }
                } else {
                    //create a work order

                    $findings = $question->evaluations($assessment->id);

                    //lets do non-inventory first
                    if (!empty($findings['non_inventory'])) {
                        $is_compliant = false;
                        $data = [];
                        $data['inventory_id'] = '';
                        $data['comment'] = implode(',', $findings['non_inventory']['comment']);
                        $data['attachment_dir'] = '/demand_work_orders/' . $assessment->user->id . '/' . $question->id . '/noninventory/' . time() . '/';
                        $data['rooms'] = $findings['non_inventory']['rooms'];

                        foreach ($findings['non_inventory']['attachment'] as $attachment) {
                            foreach (Storage::disk('s3')->files($attachment) as $file) {
                                Storage::disk('s3')->copy($file, $data['attachment_dir'] . basename($file));
                            }
                        }

                        //create work order
                        $this->createDemandWorkOrder($assessment, $question, $data);
                    }

                    //lets do one with inventory next

                    if (!empty($findings['inventories'])) {
                        foreach ($findings['inventories'] as $inventory_id => $inventory) {
                            $is_compliant = false;
                            $data = [];
                            $data['inventory_id'] = $inventory_id;
                            $data['comment'] = implode(',', $inventory['comment']);
                            $data['attachment_dir'] = '/demand_work_orders/' . $assessment->user->id . '/' . $question->id . '/inventory/' . time() . '/';
                            $data['rooms'] = $inventory['rooms'];

                            foreach ($inventory['attachment'] as $attachment) {
                                foreach (Storage::disk('s3')->files($attachment) as $file) {
                                    Storage::disk('s3')->copy($file, $data['attachment_dir'] . basename($file));
                                }
                            }

                            //create work order
                            $this->createDemandWorkOrder($assessment, $question, $data);
                        }
                    }
                }
            }
        }



        //update rounding status
        $assessment->update(['assessment_status_id' => ($is_compliant) ? 4 : 5]);

        return back();
    }



    public function fetchChecklistTypes(Request $request)
    {
        $section = Section::find($request->assessment_section_id);
        return response()->json(['checklist_types' => $section->checklistTypes]);
    }

    private function isFindingComplete(Assessment $assessment)
    {
        foreach ($assessment->checklistType->categories as $category) {
            foreach ($category->questions as $question) {
                //has to be answerd and by a leader
                if ($assessment->evaluations->where('question_id', $question->id)->count() < 1) {
                    return false;
                }
            }
        }

        return true;
    }

    private function createDemandWorkOrder(Assessment $assessment, Question $question, $data)
    {
        $wo_data = [
            'requester_name' => $assessment->user->name,
            'requester_email' => $assessment->user->email,
            'hco_id' => session('hco_id'),
            'site_id' => session('site_id'),
            'building_id' => session('building_id'),
            'inventory_id' => (!empty($data['inventory_id'])) ? $data['inventory_id'] : 0,
            'building_department_id' => $assessment->department->id,
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
            $demand_work_order->ilsmAssessment()->create(['ilsm_assessment_status_id' => 8]);
            //link finding to work order
            $assessment->workOrders()->attach([$demand_work_order->id => ['assessment_question_id' => $question->id]]);
        }
    }

    private function createEOPFinding(Assessment $assessment, Question $question, $data)
    {
        $finding_data = [
            'accreditation_id' => $data['accreditation_id'],
            'accreditation_requirement_id' => $question->eop->standardLabel->accreditation_requirement_id,
            'building_id' => session('building_id'),
            'description' => $data['comment'],
            'plan_of_action' => '',
            'measure_of_success' => '',
            'measure_of_success_date' => '',
            'internal_notes' => '',
            'benefit' => '',
            'activity' => '',
            'department_id' => $assessment->department->id,
            'potential_to_cause_harm' => '',
            'is_policy_issue' => '',
            'eop_id' => $assessment->eop_id,
            'attachment_path' => $data['attachment_dir'],
            'documents_description' => '',
            'status' => 'initial',
            'created_by_user_id' => $assessment->user->id,
        ];

        if ($eop_finding = EOPFinding::create($finding_data)) {

            $eop_finding->rooms()->sync($data['rooms']);
            $assessment->eopFindings()->attach([$eop_finding->id => ['assessment_question_id' => $question->id]]);
        }
    }
}
