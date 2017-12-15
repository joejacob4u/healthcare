{!! Form::open(['url' => 'projects/financial/edit'.$project->id, 'class' => 'form-horizontal']) !!}

<div class="form-group">
    {!! Form::label('equipment_purchase_order_amount', 'Equipment Purchase Orders or Equipment ROM Estimate:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('equipment_purchase_order_amount', $project->equipment_purchase_order_amount, ['class' => 'form-control', 'placeholder' => 'Project Purpose']) !!}
    </div>
</div>

<div class="form-group">
        {!! Form::label('equipment_purchase_order_documents_path', 'Equipment Purchase Orders Files', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! HTML::dropzone('equipment_purchase_order_documents_path',(empty($project->equipment_purchase_order_documents_path)) ? 'projects/equipment_purchase_order_documents_path/'.Auth::guard('system_user')->user()->healthsystem_id.'-'.$project->id : $project->equipment_purchase_order_documents_path,'true') !!}
    </div>
</div>




{!! Form::close()  !!}
