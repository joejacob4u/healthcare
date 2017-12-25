{!! Form::open(['url' => 'projects/leadership/edit/'.$project->id, 'class' => 'form-horizontal']) !!}

<div class="form-group">
    {!! Form::label('project_principles', 'Projects Guiding Principles:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('project_principles', $project->project_principles, ['class' => 'form-control', 'placeholder' => 'Project Purpose']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('project_type_component_id', 'Construction Risk Assessment (CRA) ', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('project_type_component_id', ['0' => 'No', '1' => 'Yes'],$project->project_type_component_id, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_icra_required', 'Infection Control Risk Assessment (ICRA)', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_icra_required', ['0' => 'No', '1' => 'Yes'],$project->is_icra_required, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>


<div class="form-group">
    <div class="col-lg-10 col-lg-offset-2">
        {{ link_to('projects', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
        {!! Form::submit('Save Accreditation', ['class' => 'btn btn-success pull-right'] ) !!}
    </div>
</div>
</fieldset>

{!! Form::close()  !!}