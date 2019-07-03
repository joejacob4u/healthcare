@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add Huddle Config')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="{{url('system-admin/huddle/configs')}}">Huddle Configs</a></li>
    <li>Add</li>
</ol>


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add Huddle Config</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'system-admin/huddle/configs', 'class' => 'form-horizontal']) !!}

            <fieldset>

            <div class="form-group">
                {!! Form::label('care_team_id', 'Care Team:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('care_team_id', $care_teams->prepend('Please Select',''), Request::old('care_team_id'), ['class' => 'form-control selectpicker','id' => 'care_team_id']); !!}
                </div>
            </div>



            <div class="form-group">
                {!! Form::label('schedule', 'Schedule', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="schedule[]"  value="sunday">Sunday
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="schedule[]" value="monday">Monday
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="schedule[]" value="tuesday">Tuesday
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="schedule[]" value="wednesday">Wednesday
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="schedule[]" value="thursday">Thursday
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="schedule[]" value="friday">Friday
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="schedule[]" value="saturday">Saturday
                    </label>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('time', 'Time:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::text('time', Request::old('time'), ['class' => 'form-control time','id' => 'time']) !!}
                </div>
            </div>



            {!! Form::hidden('healthsystem_id', session('healthsystem_id'),['id' => 'healthsystem_id']) !!}


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! Form::submit('Add Huddle Config', ['class' => 'btn btn-success pull-right'] ) !!}
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

    $('.time').flatpickr({
         enableTime: true,
         noCalendar: true,
         dateFormat: "H:i",
    });


    </script>

@endsection
