@extends('layouts.app')

@section('head')
@parent

@section('page_title','Maintenance Shifts')
@section('page_description','Add maintenance shifts here.')

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add Maintenance Shift</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/maintenance/shifts/add', 'class' => 'form-horizontal']) !!}

            <fieldset>

            <div class="form-group">
                {!! Form::label('hco_id', 'HCO', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('hco_id',$healthsystem->hcos->pluck('facility_name','id')->prepend('Please select',0), $value = '', ['class' => 'form-control selectpicker','id' => 'hco_id']) !!}
                </div>
            </div>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $value = null, ['class' => 'form-control', 'placeholder' => 'Shift Name']) !!}
                  </div>
              </div>
                <!-- Email -->

                <div class="form-group">
                    {!! Form::label('start_time', 'Start Time', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('start_time', $value = null, ['class' => 'form-control','id' => 'start_time']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('end_time', 'End Time', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('end_time', $value = null, ['class' => 'form-control','id' => 'end_time']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('days', 'Days', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="days[]"  value="sunday">Sunday
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="days[]" value="monday">Monday
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="days[]" value="tuesday">Tuesday
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="days[]" value="wednesday">Wednesday
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="days[]" value="thursday">Thursday
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="days[]" value="friday">Friday
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="days[]" value="saturday">Saturday
                        </label>
                    </div>
                </div>



                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title">Add block out period</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-sm" onclick="addPeriod()" type="button"><span class="glyphicon glyphicon-plus"></span> Add Period</button>
                    </div>
                    </div>

                    <div class="box-body" id="period-box">
                    </div>

                    <div class="box-footer">
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('admin/maintenance/shifts', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Add Shift', ['class' => 'btn btn-success pull-right'] ) !!}
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

    $("#start_time,#end_time").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        altFormat: "H:i:s"
    });

    var period_count = 0;

    function addPeriod()
    {
        period_count++;

        var html = `<div class="row" id="period_${period_count}">
                        <div class="col-xs-3">
                            <input type="text" class="form-control input-sm" name="period_start_time[]" id="period_start_time_${period_count}" placeholder="Start Time">
                        </div>
                        <div class="col-xs-3">
                            <input type="text" class="form-control input-sm" name="period_end_time[]" id="period_end_time_${period_count}" placeholder="End Time">
                        </div>
                        <div class="col-xs-5">
                            <input type="text" class="form-control input-sm" name="period_description[]" placeholder="Description">
                        </div>
                        <div class="col-xs-1">
                            <button class="btn btn-danger btn-xs" type="button" onclick="deletePeriod(${period_count})"><span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </div>`;

                    $('#period-box').append(html);

                    $("#period_"+period_count+" #period_start_time_"+period_count).flatpickr({
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        altFormat: "H:i:s"
                    });

                    $("#period_"+period_count+" #period_end_time_"+period_count).flatpickr({
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        altFormat: "H:i:s"
                    });

    }

    function deletePeriod(id)
    {
        $('#period_'+id).remove();
    }

    </script>

@endsection
