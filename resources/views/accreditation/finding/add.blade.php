@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add Finding')
@section('page_description','')



@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="/system-admin/accreditation/<?php echo session('accreditation_id'); ?>/accreditation_requirement/<?php echo session('accreditation_requirement_id'); ?>"><i class="fa fa-dashboard"></i> Accreditation Requirement</a></li>
    <li><a href="/system-admin/accreditation/eop/status/<?php echo $eop->id; ?>">EOP Status Findings</a></li>
    <li class="active">Add</li>
</ol>


<div class="callout callout-info">
    <h4>EOP : {{$eop->name}}</h4>
    <p>{{$eop->text}}</p>
</div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Populate Finding Attributes</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'system-admin/accreditation/eop/status/'.$eop->id.'/finding/add', 'class' => 'form-horizontal']) !!}
            <fieldset>
            <!-- Status -->

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('description', 'Finding Description:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('description', (!empty(Request::old('description'))) ? Request::old('description') : $description, ['class' => 'form-control', 'placeholder' => 'description','rows' => 3]) !!}
                  </div>
              </div>

                <div class="form-group">
                    {!! Form::label('department_id', 'Department:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('department_id', $building->departments->pluck('name','id')->prepend('Select',0), Request::old('department_id'), ['class' => 'form-control','id' => 'department_id']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('room_id', 'Room:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('room_id', [], Request::old('room_id'), ['class' => 'form-control','id' => 'room_id']) !!}
                    </div>
                </div>

              <div class="form-group">
                  {!! Form::label('plan_of_action', 'Plan of Action:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('plan_of_action', Request::old('plan_of_action'), ['class' => 'form-control','rows' => 3]) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('measure_of_success', 'Measure of Success:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('measure_of_success', Request::old('measure_of_success'), ['class' => 'form-control','rows' => 3]) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('measure_of_success_date', 'Measure of Success Date:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('measure_of_success_date', Request::old('measure_of_success_date'), ['class' => 'form-control date','id' => 'measure_of_success_date']) !!}
                  </div>
              </div>


              <div class="form-group">
                  {!! Form::label('internal_notes', 'Internal Notes:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('internal_notes', Request::old('internal_notes'), ['class' => 'form-control','rows' => 3]) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('benefit', 'Benefit:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('benefit', Request::old('benefit'), ['class' => 'form-control','id' => 'benefit']) !!}
                  </div>
              </div>

                <div class="form-group">
                    {!! Form::label('activity', 'Activity:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('activity', [0 => 'Select One','constant_state' => 'Constant State of Readiness Review','mock_survey' => 'Mock Survey','tjc_survey' => 'TJC Survey','ahj_survey' => 'Other AHJ Survey'], Request::old('activity'), ['class' => 'form-control']) !!}
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('potential_to_cause_harm', 'Potential to Cause Harm:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('potential_to_cause_harm', ['low' => 'Low','moderate' => 'Moderate','high' => 'High','immediate_threat_to_life' => 'Immediate Threat to Life'], Request::old('potential_to_cause_harm'), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('is_policy_issue', 'Policy Issue:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('is_policy_issue', [0 => 'No',1 => 'Yes'], Request::old('is_policy_issue'), ['class' => 'form-control']) !!}
                    </div>
                </div>



            <div class="form-group">
                  {!! Form::label('attachments_path', 'Attach Documents:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                  {!! HTML::dropzone('attachments_path','accreditation/'.session('accreditation_id').'/building/'.session('building_id').'/eop/'.$eop->id.'/finding/'.strtotime('now'),'false') !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('documents_description', 'Documents Description:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('documents_description', Request::old('documents_description'), ['class' => 'form-control','rows' => 3]) !!}
                  </div>
              </div>


              {!! Form::hidden('eop_id', $eop->id) !!}
              {!! Form::hidden('status', 'initial') !!}
              {!! Form::hidden('building_id', session('building_id')) !!}
              {!! Form::hidden('accreditation_id', session('accreditation_id')) !!}
              {!! Form::hidden('accreditation_requirement_id', session('accreditation_requirement_id')) !!}

              {!! Form::hidden('created_by_user_id',Auth::guard('system_user')->user()->id) !!}

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('system-admin/accreditation/eop/status/'.$eop->id,'Cancel', ['class' => 'btn btn-warning'] ) !!}
                        {!! Form::submit('Add Finding', ['class' => 'btn btn-success pull-right'] ) !!}
                    </div>
                </div>

            </fieldset>

            {!! Form::close()  !!}
        </div>

   <script>
    $(".date").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });

    $("#department_id").change(function(){

        if($(this).val() != 0)
        {
                $.ajax({
                type: 'POST',
                url: '{{ url('system-admin/accreditation/eop/status/fetch/rooms') }}',
                data: { '_token' : '{{ csrf_token() }}', 'department_id': $(this).val() },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    $('#room_id').html('');

                    var html = '<option value="0">Select Room</option>';

                    $.each(data.rooms, function(index, value) {
                        html += '<option value="'+value.id+'">'+value.room_number+'</option>';
                    });

                    $('#room_id').append(html);
                    $('#room_id').selectpicker('render');
                },
                complete:function()
                {
                    $('.overlay').remove();
                },
                error:function()
                {
                    // failed request; give feedback to user
                }
            });

        }
        
      });
  </script>



@endsection