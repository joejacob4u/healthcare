<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class WorkOrderAudit extends Model
{
    protected $table = 'maintenance_work_order_audits';
    
    protected $guarded = ['id'];
}
