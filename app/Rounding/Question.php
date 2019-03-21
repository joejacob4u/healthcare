<?php

namespace App\Rounding;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'rounding_questions';

    protected $fillable = ['rounding_category_id','system_tier_id','question','answers','eops','work_order_trade_id','work_order_problem_id','negative_answers'];

    protected $casts = ['eops' => 'array','answers' => 'array'];

    public function category()
    {
        return $this->belongsTo('App\Rounding\Category', 'rounding_category_id');
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
}
