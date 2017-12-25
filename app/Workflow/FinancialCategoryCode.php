<?php

namespace App\Workflow;

use Illuminate\Database\Eloquent\Model;

class FinancialCategoryCode extends Model
{
    protected $table = 'financial_category_codes';
    protected $guarded = ['id'];
}
