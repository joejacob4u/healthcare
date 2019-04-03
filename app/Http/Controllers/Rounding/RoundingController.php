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
        return view('rounding.rounding.questions', ['rounding' => $rounding,'rooms' => $rooms,'inventories' => $inventories]);
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

            return response()->json(['finding' => $finding, 'no_of_files' => count($files),'files' => $files,'is_finding_complete' => $is_finding_complete]);
        }
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
}
