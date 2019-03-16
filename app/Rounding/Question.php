<?php

namespace App\Rounding;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'rounding_questions';

    protected $fillable = ['rounding_category_id','system_tier_id','question','answers','eops'];

    protected $casts = ['eops' => 'array','answers' => 'array'];

    public function category()
    {
        return $this->belongsTo('App\Rounding\Category', 'rounding_category_id');
    }

    public function systemTier()
    {
        return $this->belongsTo('App\SystemTier', 'system_tier_id');
    }
}
