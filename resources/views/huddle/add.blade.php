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
                {!! Form::label('hco_id', 'HCO:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('hco_id', $hcos->prepend('Please Select',''), Request::old('hco_id'), ['class' => 'form-control selectpicker','id' => 'hco_id']); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('site_id', 'Site:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('site_id', [], '', ['class' => 'form-control','id' => 'site_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('building_id', 'Building:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('building_id', [], '', ['class' => 'form-control','id' => 'building_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('department_id', 'Department:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('department_id', [], '', ['class' => 'form-control selectpicker','id' => 'department_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group" id="care-team-div" style="display:none">
                {!! Form::label('care_teams', 'Report to Care Team(s):', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('care_teams[]', [], '', ['class' => 'form-control selectpicker','id' => 'care_teams','data-live-search' => "true", 'multiple' => true]); !!}
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

            <div class="form-group">
                {!! Form::label('location', 'Location:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::text('location', Request::old('location'), ['class' => 'form-control','id' => 'location']) !!}
                </div>
            </div>
            

            <div class="form-group">
                {!! Form::label('leader_user_id', 'Main Leader:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('leader_user_id', $users->prepend('Please Select',0), '', ['class' => 'form-control selectpicker','id' => 'leader_user_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('alternative_leader_user_id', 'Alternative Main Leader:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('alternative_leader_user_id', $users->prepend('Please Select',0), '', ['class' => 'form-control selectpicker','id' => 'alternative_leader_user_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('recorder_of_data_user_id', 'Recorder of Data:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('recorder_of_data_user_id', $users->prepend('Please Select',0), '', ['class' => 'form-control selectpicker','id' => 'recorder_of_data_user_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('alternative_recorder_of_data_user_id', 'Alternative Recorder of Data:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('alternative_recorder_of_data_user_id', $users->prepend('Please Select',0), '', ['class' => 'form-control selectpicker','id' => 'alternative_recorder_of_data_user_id','data-live-search' => "true"]); !!}
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
