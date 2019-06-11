@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Edit Huddle Config')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="{{url('system-admin/huddle/configs')}}">Huddle Configs</a></li>
    <li>Edit</li>
</ol>


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Huddle Config</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'system-admin/huddle/configs/'.$huddle_config->id.'/edit', 'class' => 'form-horizontal']) !!}

            <fieldset>

            <div class="form-group">
                {!! Form::label('name', 'Care Team Name:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::text('name', $huddle_config->name, ['class' => 'form-control','id' => 'name']) !!}
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('hco_id', 'HCO:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('hco_id', $hcos->prepend('Please Select',''), $huddle_config->hco_id, ['class' => 'form-control selectpicker','id' => 'hco_id']); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('site_id', 'Site:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('site_id', \App\Regulatory\Site::where('hco_id',$huddle_config->hco_id)->pluck('name','id'), $huddle_config->site_id, ['class' => 'form-control','id' => 'site_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('building_id', 'Building:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('building_id', \App\Regulatory\Building::where('site_id',$huddle_config->site_id)->pluck('name','id'), $huddle_config->building_id, ['class' => 'form-control','id' => 'building_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('department_id', 'Department:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('department_id', \App\Regulatory\BuildingDepartment::where('building_id',$huddle_config->building_id)->pluck('name','id'), $huddle_config->department_id, ['class' => 'form-control selectpicker','id' => 'department_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('huddle_tier_id', 'Tier:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('huddle_tier_id', $tiers->prepend('Please Select',0), $huddle_config->huddle_tier_id, ['class' => 'form-control selectpicker','id' => 'huddle_tier_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('schedule', 'Schedule', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="schedule[]" value="sunday" @if(in_array('sunday',$huddle_config->schedule)) checked  @endif>Sunday
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="schedule[]" value="monday" @if(in_array('monday',$huddle_config->schedule)) checked  @endif>Monday
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="schedule[]" value="tuesday" @if(in_array('tuesday',$huddle_config->schedule)) checked  @endif>Tuesday
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="schedule[]" value="wednesday" @if(in_array('wednesday',$huddle_config->schedule)) checked  @endif>Wednesday
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="schedule[]" value="thursday" @if(in_array('thursday',$huddle_config->schedule)) checked  @endif>Thursday
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="schedule[]" value="friday" @if(in_array('friday',$huddle_config->schedule)) checked  @endif>Friday
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="schedule[]" value="saturday" @if(in_array('saturday',$huddle_config->schedule)) checked  @endif>Saturday
                        </label>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('time', 'Time:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::text('time', $huddle_config->time, ['class' => 'form-control time','id' => 'time']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('location', 'Location:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::text('location', $huddle_config->location, ['class' => 'form-control','id' => 'location']) !!}
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('leader_user_id', 'Main Leader:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('leader_user_id', $users->prepend('Please Select',0), $huddle_config->leader_user_id, ['class' => 'form-control selectpicker','id' => 'leader_user_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('alternative_leader_user_id', 'Alternative Main Leader:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('alternative_leader_user_id', $users->prepend('Please Select',0), $huddle_config->alternative_leader_user_id, ['class' => 'form-control selectpicker','id' => 'alternative_leader_user_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('recorder_of_data_user_id', 'Recorder of Data:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('recorder_of_data_user_id', $users->prepend('Please Select',0), $huddle_config->recorder_of_data_user_id, ['class' => 'form-control selectpicker','id' => 'recorder_of_data_user_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('alternative_recorder_of_data_user_id', 'Alternative Recorder of Data:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('alternative_recorder_of_data_user_id', $users->prepend('Please Select',0), $huddle_config->alternative_recorder_of_data_user_id, ['class' => 'form-control selectpicker','id' => 'alternative_recorder_of_data_user_id','data-live-search' => "true"]); !!}
                </div>
            </div>


            {!! Form::hidden('healthsystem_id', session('healthsystem_id'),['id' => 'healthsystem_id']) !!}


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! Form::submit('Edit Huddle Config', ['class' => 'btn btn-success pull-right'] ) !!}
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

    $("#hco_id").change(function(){
        
        var hco_id = $("#hco_id").val();

        $.ajax({
          type: 'POST',
          url: '{{ url('system-admin/accreditation/fetch/sites') }}',
          data: { '_token' : '{{ csrf_token() }}', 'hco_id': hco_id },
          beforeSend:function()
          {
          },
          success:function(data)
          {
            $('#site_id').html('');

            var html = '<option value="0">Select Site</option>';

            $.each(data.sites, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+' ('+value.address+' ) - #'+value.site_id+'</option>';
            });

            $('#site_id').append(html);
            $('#site_id').selectpicker('refresh');
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



      });

      $("#site_id").change(function(){
        
        var site_id = $("#site_id").val();

        $.ajax({
          type: 'POST',
          url: '{{ url('system-admin/accreditation/fetch/buildings') }}',
          data: { '_token' : '{{ csrf_token() }}', 'site_id': site_id },
          beforeSend:function()
          {
            $('#accreditation_modal .callout').show();
          },
          success:function(data)
          {
            $('#building_id').html('');

            var html = '<option value="0">Select Building</option>';

            $.each(data.buildings, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+'- #'+value.building_id+'</option>';
            });

            $('#building_id').append(html);
            $('#building_id').selectpicker('refresh');
            $('#accreditation_modal .callout').hide();

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
      });

    $("#building_id").change(function(){
        
        var building_id = $("#building_id").val();

        $.ajax({
            type: 'POST',
            url: '{{ url('buildings/fetch/departments') }}',
            data: { '_token' : '{{ csrf_token() }}', 'building_id': building_id },
            beforeSend:function()
            {
                $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
            },
            success:function(data)
            {
                $('#department_id').html('');

                var html = '<option value="0">Select Department</option>';

                $.each(data.departments, function(index, value) {
                    html += '<option value="'+value.id+'">'+value.name+'</option>';
                });

                $('#department_id').append(html);
                $('#department_id').selectpicker('refresh');
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

      });



    </script>

@endsection
