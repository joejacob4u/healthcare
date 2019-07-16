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
                {!! Form::label('care_team_id', 'Care Team:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('care_team_id', $care_teams->prepend('Please Select',''), $huddle_config->care_team_id, ['class' => 'form-control selectpicker','id' => 'care_team_id']); !!}
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

    $("#care_team_id").change(function(){
        
        var care_team_id = $("#care_team_id").val();

        if(care_team_id)
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('system-admin/huddle/configs/fetch/care-teams') }}',
                data: { '_token' : '{{ csrf_token() }}', 'care_team_id': care_team_id },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    if(data.user_select == true)
                    {
                        $('#care_teams').html('');

                        var html = '<option value="0">Select Care Team</option>';

                        $.each(data.care_teams, function(index, value) {
                            html += '<option value="'+value.id+'">'+value.name+'</option>';
                        });

                        $('#care-team-div').show();

                        $('#care_teams').append(html);
                        $('#care_teams').selectpicker('refresh');

                    }
                    else
                    {
                        $('#care_teams').html('');
                        $('#care-team-div').hide();
                        $('#care_teams').selectpicker('val','');
                    }
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
        else
        {
            $('#care_teams').html('');
            $('#care-team-div').hide();
            $('#care_teams').selectpicker('val','');
        }


      });




    </script>

@endsection
