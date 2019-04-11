<?php

namespace App\Http\Controllers\Rounding;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rounding\Rounding;
use Illuminate\Support\Facades\Storage;
use App\Regulatory\Room;
use App\Equipment\Equipment;
use App\Rounding\QuestionFinding;
use function GuzzleHttp\json_decode;
use App\Equipment\DemandWorkOrder;
use App\Rounding\Question;

class RoundingController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        $roundings = Rounding::where('building_id', session('building_id'))->paginate(30);
        return view('rounding.rounding.index', ['roundings' => $roundings]);
    }

    public function questions(Rounding $rounding)
    {
        $equipments = Equipment::where('building_id', session('building_id'))->get();

        $inventories = [];

        foreach ($equipments as $equipment) {
            foreach ($equipment->inventories as $inventory) {
                $inventories[$inventory->id] = $inventory;
            }
        }

        $rooms = Room::where('building_department_id', $rounding->config->department->id)->pluck('room_number', 'id');
        return view('rounding.rounding.questions', ['rounding' => $rounding, 'rooms' => $rooms, 'inventories' => $inventories]);
    }

    public function deleteFinding(Request $request)
    {
        $question_finding = QuestionFinding::find($request->id);

        if ($question_finding->delete()) {
            if (!empty($question_finding->finding['attachment'])) {
                Storage::disk('s3')->deleteDirectory($question_finding->finding['attachment']);
            }

            return response()->json(['status' => 'success']);
        }
    }

    public function saveFinding(Request $request, Rounding $rounding)
    {
        if ($finding = QuestionFinding::create([
            'rounding_id' => $request->rounding_id,
            'question_id' => $request->question_id,
            'user_id' => $request->user_id,
            'finding' => json_decode($request->finding, true),
            'is_leader' => $request->is_leader
        ])) {
            $is_finding_complete = false;
            $finding_data = json_decode($request->finding, true);
            $files = Storage::disk('s3')->files($finding_data['attachment']);

            if ($rounding->status->id == 1) {
                $rounding->update(['rounding_status_id' => 2]);
            }

            if ($this->isFindingComplete($rounding)) {
                $is_finding_complete = true;
                $rounding->update(['rounding_status_id' => 3]);
            }

            return response()->json(['finding' => $finding, 'no_of_files' => count($files), 'files' => $files, 'is_finding_complete' => $is_finding_complete, 'question' => $finding->question]);
        }
    }

    public function editFinding(Request $request, Rounding $rounding)
    {
        $finding = QuestionFinding::find($request->finding_id);

        if ($finding->update([
            'rounding_id' => $request->rounding_id,
            'question_id' => $request->question_id,
            'user_id' => $request->user_id,
            'finding' => json_decode($request->finding, true),
            'is_leader' => $request->is_leader
        ])) {
            $is_finding_complete = false;
            $finding_data = json_decode($request->finding, true);
            $files = Storage::disk('s3')->files($finding_data['attachment']);

            if ($rounding->status->id == 1) {
                $rounding->update(['rounding_status_id' => 2]);
            }

            if ($this->isFindingComplete($rounding)) {
                $is_finding_complete = true;
                $rounding->update(['rounding_status_id' => 3]);
            }


            return response()->json(['finding' => $finding, 'no_of_files' => count($files), 'files' => $files, 'is_finding_complete' => $is_finding_complete, 'question' => $finding->question]);
        }
    }

    public function verify(Request $request)
    {
        $rounding = Rounding::find($request->rounding_id);
        $is_compliant = true;

        foreach ($rounding->config->checklistType->categories as $category) {
            foreach ($category->questions as $question) {

                $findings = $question->findings($rounding->id);

                //lets do non-inventory first
                if (!empty($findings['non_inventory'])) {
                    $is_compliant = false;
                    $data = [];
                    $data['inventory_id'] = '';
                    $data['comment'] = implode(',', $findings['non_inventory']['comment']);
                    $data['attachment_dir'] = '/demand_work_orders/' . $rounding->config->user->id . '/' . $question->id . '/noninventory/' . time() . '/';
                    $data['rooms'] = $findings['non_inventory']['rooms'];

                    foreach ($findings['non_inventory']['attachment'] as $attachment) {
                        foreach (Storage::disk('s3')->files($attachment) as $file) {
                            Storage::disk('s3')->copy($file, $data['attachment_dir'] . basename($file));
                        }
                    }

                    //create work order
                    $this->createDemandWorkOrder($rounding, $question, $data);
                }

                //lets do one with inventory next

                if (!empty($findings['inventories'])) {
                    foreach ($findings['inventories'] as $inventory_id => $inventory) {
                        $is_compliant = false;
                        $data = [];
                        $data['inventory_id'] = $inventory_id;
                        $data['comment'] = implode(',', $inventory['comment']);
                        $data['attachment_dir'] = '/demand_work_orders/' . $rounding->config->user->id . '/' . $question->id . '/inventory/' . time() . '/';
                        $data['rooms'] = $inventory['rooms'];

                        foreach ($inventory['attachment'] as $attachment) {
                            foreach (Storage::disk('s3')->files($attachment) as $file) {
                                Storage::disk('s3')->copy($file, $data['attachment_dir'] . basename($file));
                            }
                        }

                        //create work order
                        $this->createDemandWorkOrder($rounding, $question, $data);
                    }
                }
            }
        }



        //update rounding status
        $rounding->update(['rounding_status_id' => ($is_compliant) ? 4 : 5]);

        return back();
    }

    private function isFindingComplete(Rounding $rounding)
    {
        foreach ($rounding->config->checklistType->categories as $category) {
            foreach ($category->questions as $question) {
                //has to be answerd and by a leader
                if ($rounding->findings->where('question_id', $question->id)->where('is_leader', 1)->count() < 1) {
                    return false;
                }
            }
        }

        return true;
    }

    private function createDemandWorkOrder(Rounding $rounding, Question $question, $data)
    {
        $wo_data = [
            'requester_name' => $rounding->config->user->name,
            'requester_email' => $rounding->config->user->email,
            'hco_id' => session('hco_id'),
            'site_id' => session('site_id'),
            'building_id' => session('building_id'),
            'inventory_id' => (!empty($data['inventory_id'])) ? $data['inventory_id'] : 0,
            'building_department_id' => $rounding->config->department->id,
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
            $rounding->workOrders()->attach([$demand_work_order->id => ['rounding_question_id' => $question->id]]);
        }
    }
}
