@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add Huddle')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="{{url('huddle')}}">Huddle</a></li>
    <li>Add</li>
</ol>


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add Huddle</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'huddle', 'class' => 'form-horizontal']) !!}

            <fieldset>
            <div class="form-group">
                {!! Form::label('care_team_id', 'Care Team:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('care_team_id', $care_teams->prepend('Please Select',''), Request::old('care_team_id'), ['class' => 'form-control selectpicker','id' => 'care_team_id','multiple' => false]); !!}
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('attendance[]', 'Attendance:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('attendance[]', $users, Request::old('attendance'), ['class' => 'form-control selectpicker','id' => 'attendance','multiple' => true]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('has_no_capacity_constraint', 'This huddle has no capacity constraints:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('has_no_capacity_constraint', [1 => 'Yes', 0 => 'No'], Request::old('has_no_capacity_constraint'), ['class' => 'form-control selectpicker','id' => 'has_no_capacity_constraint']); !!}
                </div>
            </div>

            <div id="constraint_div">

                <div class="form-group">
                    {!! Form::label('no_of_available_beds', 'Number of Available Beds:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                    {!! Form::text('no_of_available_beds', Request::old('no_of_available_beds'), ['class' => 'form-control','id' => 'no_of_available_beds']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('no_of_occupied_beds', 'Number of Occupied Beds:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                    {!! Form::text('no_of_occupied_beds', Request::old('no_of_occupied_beds'), ['class' => 'form-control','id' => 'no_of_occupied_beds']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('no_of_out_of_commission_beds', 'Number of Out of Commission Beds:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                    {!! Form::text('no_of_out_of_commission_beds', Request::old('no_of_out_of_commission_beds'), ['class' => 'form-control','id' => 'no_of_out_of_commission_beds']) !!}
                    </div>
                </div>

            </div>

            <div class="form-group">
                {!! Form::label('date', 'Date:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::text('date', Request::old('date'), ['class' => 'form-control date','id' => 'date']) !!}
                </div>
            </div>


            {!! Form::hidden('recorder_of_data_user_id', Auth::user()->id, ['id' => 'recorder_of_data_user_id']) !!}
            {!! Form::hidden('healthsystem_id', session('healthsystem_id'),['id' => 'healthsystem_id']) !!}


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! Form::submit('Initiate Huddle', ['class' => 'btn btn-success pull-right'] ) !!}
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

    <script>

    $('.date').flatpickr({
         enableTime: true,
         dateFormat: "Y-m-d H:i:S",
    });

    $('#has_no_capacity_constraint').change(function(){
        
        if($(this).val() == 1)
        {
            $('#constraint_div').hide();
        }
        else
        {
            $('#constraint_div').show();
        }
    });


    </script>

@endsection
