<?php

namespace App\Assessment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Question extends Model
{
    protected $table = 'assessment_questions';

    protected $fillable = ['assessment_category_id', 'system_tier_id', 'question', 'answers', 'eops', 'work_order_trade_id', 'work_order_problem_id', 'negative_answers'];

    protected $casts = ['eops' => 'array', 'answers' => 'array'];

    public function category()
    {
        return $this->belongsTo('App\Assessment\Category', 'assessment_category_id');
    }

    public function systemTier()
    {
        return $this->belongsTo('App\SystemTier', 'system_tier_id');
    }

    public function trade()
    {
        return $this->belongsTo('App\Equipment\Trade', 'work_order_trade_id');
    }

    public function problem()
    {
        return $this->belongsTo('App\Equipment\Problem', 'work_order_problem_id');
    }

    public function findings($assessment_id)
    {
        $findings = QuestionFinding::where('assessment_id', $assessment_id)->where('question_id', $this->id)->get();

        $inventories = [];
        $non_inventory = [];

        foreach ($findings as $finding) {

            if (isset($finding->finding['inventory_id'])) {
                $inventories[$finding->finding['inventory_id']]['comment'][] = $finding->finding['comment'];
                $inventories[$finding->finding['inventory_id']]['rooms'][] = $finding->finding['rooms'][0];
                $inventories[$finding->finding['inventory_id']]['attachment'][] = $finding->finding['attachment'];
            } else {
                if (count($finding->finding['rooms']) > 0) {
                    $non_inventory['comment'][] = $finding->finding['comment'];

                    //rooms
                    foreach ($finding->finding['rooms'] as $room) {
                        $non_inventory['rooms'][] = $room;
                    }
                    $non_inventory['attachment'][] = $finding->finding['attachment'];
                }
            }
        }

        return ['inventories' => $inventories, 'non_inventory' => $non_inventory];
    }
}
