{!! Form::open(['url' => 'projects/facility/edit/'.$project->id, 'class' => 'form-horizontal']) !!}

<div class="form-group">
    {!! Form::label('is_evs_required', 'Will EVS be needed for interim or final  terminal clean?', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_evs_required', ['0' => 'No', '1' => 'Yes'], $project->is_evs_required, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_utilities_need_upgrade', 'Are there any specific utilities that needs to be upgraded or new install for this project/equipment?', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_utilities_need_upgrade', ['0' => 'No', '1' => 'Yes'], $project->is_utilities_need_upgrade, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_increase_decrease_sqft', 'Is this project increasing or decreasing the square footage of the existing space?', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_increase_decrease_sqft', ['0' => 'No', '1' => 'Yes'], $project->is_increase_decrease_sqft, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('project_complexity', 'Project Complexity:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('project_complexity', ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'], $project->project_complexity, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
<div class="col-lg-10 col-lg-offset-2">
    {{ link_to('projects', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
    {!! Form::submit('Save Facilities', ['class' => 'btn btn-success pull-right'] ) !!}
</div>
</div>
</fieldset>


{!! Form::close()  !!}