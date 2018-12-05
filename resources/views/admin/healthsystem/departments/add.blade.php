@extends('layouts.app')

@section('head')
@parent
@endsection
@section('page_title','Add a Department')
@section('page_description','add department here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add department for {{$building->name}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/buildings/'.$building->id.'/departments/add', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <div class="form-group">
                  {!! Form::label('name', 'Department Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $value = '', ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                  </div>
              </div>

              <!-- Phone -->
              <div class="form-group">
                  {!! Form::label('business_unit_cost_center', 'Business Unit / Cost Center:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('business_unit_cost_center', $value = '', ['class' => 'form-control', 'placeholder' => '']) !!}
                  </div>
              </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('admin/sites/'.$building->site->id.'/buildings/'.$building->id.'/departments', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Add Department', ['class' => 'btn btn-success pull-right'] ) !!}
                    </div>
                </div>

            </fieldset>
            {!! Form::hidden('building_id', $building->id, ['class' => 'form-control']) !!}
            {!! Form::close()  !!}
               </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
     


    </div>

@endsection
