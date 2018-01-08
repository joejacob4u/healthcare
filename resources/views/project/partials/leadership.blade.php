{!! Form::open(['url' => 'projects/leadership/edit/'.$project->id, 'class' => 'form-horizontal']) !!}

<div class="form-group">
    {!! Form::label('project_principles', 'Projects Guiding Principles:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('project_principles', $project->project_principles, ['class' => 'form-control', 'placeholder' => 'Project Purpose']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('project_champion_user_id', 'Project Champion', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('project_champion_user_id', $health_system->contractors->pluck('name','id'),Request::old('project_champion_user_id'), ['class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('project_manager_user_id', 'Project Manager', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('project_manager_user_id', $health_system->contractors->pluck('name','id'),Request::old('project_manager_user_id'), ['class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('healthsystem_admin_user_id', 'Health System Administrator (Senior Leader) who Approves this Capital Investment', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('healthsystem_admin_user_id', $health_system->users->whereIn('role_id', [2, 3])->pluck('name','id'),Request::old('healthsystem_admin_user_id'), ['class' => 'form-control']); !!}
    </div>
</div>





<div class="form-group">
    <div class="col-lg-10 col-lg-offset-2">
        {{ link_to('projects', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
        {!! Form::submit('Save Leadership', ['class' => 'btn btn-success pull-right'] ) !!}
    </div>
</div>
</fieldset>

{!! Form::close()  !!}