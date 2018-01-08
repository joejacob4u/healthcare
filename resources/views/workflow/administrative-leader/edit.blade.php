@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Administrative Leader</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'workflows/administrative-leaders/edit/'.$administrative_leader->id, 'class' => 'form-horizontal']) !!}

            <fieldset>


              <div class="form-group">
                  {!! Form::label('name', 'Leader Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $administrative_leader->name, ['class' => 'form-control', 'placeholder' => 'name']) !!}
                  </div>
              </div>

                <div class="form-group">
                    {!! Form::label('title', 'Title:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!! Form::select('workflow_approval_level_leader_id', $approval_level_leaders, $administrative_leader->workflow_approval_level_leader_id, ['class' => 'form-control selectpicker']); !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'E-Mail:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('email', $administrative_leader->email, ['class' => 'form-control', 'placeholder' => 'E-mail']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('phone', 'Phone:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('phone', $administrative_leader->phone, ['class' => 'form-control', 'placeholder' => 'Phone']) !!}
                    </div>
                </div>




                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('workflows/administrative-leaders', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Edit Administrative Leader', ['class' => 'btn btn-success pull-right'] ) !!}
                    </div>
                </div>


            </fieldset>

            {!! Form::close()  !!}
               </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer-->
    </div>

@endsection
