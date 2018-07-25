@extends('layouts.app')

@section('head')
@parent

@section('page_title','Edit Maintenance Shift')
@section('page_description','Edit maintenance shift.')

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Maintenance Shift</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/maintenance/shifts/edit/'.$shift->id, 'class' => 'form-horizontal']) !!}

            <fieldset>

            <div class="form-group">
                {!! Form::label('hco_id', 'HCO', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('hco_id',$healthsystem->hcos->pluck('facility_name','id')->prepend('Please select',0), $shift->hco_id, ['class' => 'form-control selectpicker','id' => 'hco_id']) !!}
                </div>
            </div>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $shift->name, ['class' => 'form-control', 'placeholder' => 'Shift Name']) !!}
                  </div>
              </div>
                <!-- Email -->

                <div class="form-group">
                    {!! Form::label('start_time', 'Start Time', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('start_time', $shift->start_time, ['class' => 'form-control','id' => 'start_time']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('end_time', 'End Time', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('end_time', $shift->end_time, ['class' => 'form-control','id' => 'end_time']) !!}
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
                        @foreach($shift->periods as $period)
                            <div class="row" id="period_{{$period->id}}">
                                <div class="col-xs-3">
                                    <input type="text" class="form-control input-sm" name="period_start_time[]" id="period_start_time_{{$period->id}}" value="{{$period->start_time}}" placeholder="Start Time">
                                </div>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control input-sm" name="period_end_time[]" id="period_end_time_{{$period->id}}" value="{{$period->end_time}}" placeholder="End Time">
                                </div>
                                <div class="col-xs-5">
                                    <input type="text" class="form-control input-sm" name="period_description[]" value="{{$period->description}}" placeholder="Description">
                                </div>
                                <div class="col-xs-1">
                                    <button class="btn btn-danger btn-xs" type="button" onclick="deletePeriod({{$period->id}})"><span class="glyphicon glyphicon-remove"></span></button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="box-footer">
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('admin/maintenance/shifts', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Edit Shift', ['class' => 'btn btn-success pull-right'] ) !!}
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

    var period_count = {{ $shift->periods->max('id') }};

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

    @foreach($shift->periods as $period)
        
        $("#period_{{$period->id}} #period_start_time_{{$period->id}}").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            altFormat: "H:i:s"
        });

        $("#period_{{$period->id}} #period_end_time_{{$period->id}}").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            altFormat: "H:i:s"
        });
        
    @endforeach



    function deletePeriod(id)
    {
        $('#period_'+id).remove();
    }

    </script>

@endsection
