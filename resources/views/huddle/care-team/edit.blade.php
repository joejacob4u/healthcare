@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add Care Team')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="{{url('system-admin/huddle/configs#care-teams')}}">Care Teams</a></li>
    <li>Add</li>
</ol>


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Care Team</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'system-admin/huddle/care-teams/'.$care_team->id.'/edit', 'class' => 'form-horizontal']) !!}

            <fieldset>

            <div class="form-group">
                {!! Form::label('name', 'Care Team Name:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::text('name', $care_team->name, ['class' => 'form-control','id' => 'name']) !!}
                </div>
            </div>



            <div class="form-group">
                {!! Form::label('tier_id', 'Tier:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('tier_id', $tiers->prepend('Please Select',0), $care_team->tier_id, ['class' => 'form-control selectpicker','id' => 'tier_id','data-live-search' => "true"]); !!}
                </div>
            </div>


            {!! Form::hidden('healthsystem_id', session('healthsystem_id'),['id' => 'healthsystem_id']) !!}


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! Form::submit('Edit Care Team', ['class' => 'btn btn-success pull-right'] ) !!}
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
