{!! Form::open(['url' => 'projects/administration/edit/'.$project->id, 'class' => 'form-horizontal']) !!}

<div class="form-group" style="margin-top:15px;">
    {!! Form::label('project_start_date', 'Project Start Date:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::date('project_start_date', $project->project_start_date, ['class' => 'form-control', 'placeholder' => 'project start date']) !!}
    </div>
</div> 

<div class="form-group">
    {!! Form::label('project_end_date', 'Project End Date:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::date('project_end_date', $project->project_end_date, ['class' => 'form-control', 'placeholder' => 'project end date']) !!}
    </div>
</div>  

<div class="form-group">
    {!! Form::label('project_workday_start_time', 'Project Workday Start Time:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('project_workday_start_time', $project->project_workday_start_time, ['class' => 'form-control', 'placeholder' => 'project workday start time']) !!}
    </div>
</div> 

<div class="form-group">
    {!! Form::label('project_workday_end_time', 'Project Workday End Time:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('project_workday_start_time', $project->project_workday_start_time, ['class' => 'form-control', 'placeholder' => 'project workday start time']) !!}
    </div>
</div>                    
                   
                     

<h3>Project Statuses</h3>
<div class="panel panel-info" style="margin-top:15px;">
      <div class="panel-heading">Fill out project status requirements for each stage below:</div>
      <div class="panel-body">
      @foreach($project_statuses as $project_status)
          <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{$project_status->status}}</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                  {!! Form::label('estimated_start_date_'.$project_status->id, 'Estimated start date:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('estimated_start_dates['.$project_status->id.']', (!empty($project->statuses->where('id',$project_status->id)->first())) ? $project->statuses->where('id',$project_status->id)->first()->pivot->estimated_start_date : '', ['class' => 'form-control', 'placeholder' => 'estimated start date']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('estimated_end_date_'.$project_status->id, 'Estimated end date:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('estimated_end_dates['.$project_status->id.']', (!empty($project->statuses->where('id',$project_status->id)->first())) ? $project->statuses->where('id',$project_status->id)->first()->pivot->estimated_end_date : '', ['class' => 'form-control', 'placeholder' => 'estimated end date']) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('actual_end_date_'.$project_status->id, 'Actual end date:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('actual_end_dates['.$project_status->id.']', (!empty($project->statuses->where('id',$project_status->id)->first())) ? $project->statuses->where('id',$project_status->id)->first()->pivot->actual_end_date : '', ['class' => 'form-control', 'placeholder' => 'actual end date']) !!}
                  </div>
              </div>                      


            <div class="form-group">
                  {!! Form::label('notes_'.$project_status->id, 'Note:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('notes['.$project_status->id.']', (!empty($project->statuses->where('id',$project_status->id)->first())) ? $project->statuses->where('id',$project_status->id)->first()->pivot->note : '', ['class' => 'form-control', 'placeholder' => 'note']) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('is_completed_'.$project_status->id, 'Completed:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('is_completed['.$project_status->id.']', [0 => 'No',1 => 'Yes'], (!empty($project->statuses->where('id',$project_status->id)->first())) ? $project->statuses->where('id',$project_status->id)->first()->pivot->is_completed : '', ['class' => 'form-control selectpicker']); !!}
                  </div>
              </div>

            </div>
        </div>
    @endforeach

      </div>
</div>


<div class="form-group">
    <div class="col-lg-10 col-lg-offset-2">
        {{ link_to('projects', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
        {!! Form::submit('Save Administration', ['class' => 'btn btn-success pull-right'] ) !!}
    </div>
</div>
</fieldset>

{!! Form::close()  !!}