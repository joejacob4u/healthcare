<?php

namespace App\Tracer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Question extends Model
{
    protected $table = 'tracer_questions';

    protected $fillable = ['tracer_category_id', 'system_tier_id', 'question', 'answers', 'eops', 'work_order_trade_id', 'work_order_problem_id', 'negative_answers'];

    protected $casts = ['answers' => 'array'];

    public function category()
    {
        return $this->belongsTo('App\Tracer\Category', 'tracer_category_id');
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

    public function eop()
    {
        return $this->belongsTo('App\Regulatory\EOP', 'eops');
    }

    public function evaluations($tracer_id)
    {
        $findings = QuestionEvaluation::where('tracer_id', $tracer_id)->where('question_id', $this->id)->get();

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
                    $non_inventory['accreditation_id'][] = (isset($finding->finding['accreditation_id'])) ? $finding->finding['accreditation_id'] : '';
                }
            }
        }

        return ['inventories' => $inventories, 'non_inventory' => $non_inventory];
    }
}
