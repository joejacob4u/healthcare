@extends('layouts.app')

@section('head')
@parent

@section('page_title','Maintenance Users')
@section('page_description','Add maintenance users.')

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add user to Maintenance</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/maintenance/users/add', 'class' => 'form-horizontal','files' => true]) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $value = null, ['class' => 'form-control', 'placeholder' => 'User Name']) !!}
                  </div>
              </div>
                <!-- Email -->

                <div class="form-group">
                    {!! Form::label('email', 'E-Mail', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('email', $value = null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('phone', 'Phone', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('phone', $value = null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                  {!! Form::label('maintenance_hco_id', 'HCO', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('maintenance_hco_id[]',$healthsystem->hcos->pluck('facility_name','id')->prepend('Please select',0), $value = '', ['class' => 'form-control selectpicker','id' => 'maintenance_hco_id','multiple' => true]) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('site_id', 'Site', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('maintenance_site_id[]',[], $value = '', ['class' => 'form-control','disabled' => true,'id' => 'maintenance_site_id','multiple' => true]) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('maintenance_building_id', 'Building', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('maintenance_building_id[]',[], $value = '', ['class' => 'form-control','disabled' => true,'id' => 'maintenance_building_id','multiple' => true]) !!}
                  </div>
                </div>

                  <div class="form-group">
                    {!! Form::label('maintenance_department_id', 'Department:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                    {!! Form::select('maintenance_department_id[]', [], '', ['class' => 'form-control selectpicker','id' => 'maintenance_department_id','data-live-search' => "true",'disabled' => true]); !!}
                    </div>
                </div>




                {!! Form::hidden('status', 'active', ['class' => 'form-control']) !!}
                {!! Form::hidden('role_id', 5, ['class' => 'form-control']) !!}
                {!! Form::hidden('healthsystem_id', Auth::user()->healthsystem_id) !!}



                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('admin/maintenance/users', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Add User', ['class' => 'btn btn-success pull-right'] ) !!}
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

    $("#maintenance_hco_id").change(function(){

        if( $('#maintenance_hco_id :selected').length > 0){
            var hcos = [];

            $('#maintenance_hco_id :selected').each(function(i, selected) {
                hcos[i] = $(selected).val();
            });
        }

        $.ajax({
          type: 'POST',
          url: '{{ url('admin/maintenance/users/fetch/sites') }}',
          data: { '_token' : '{{ csrf_token() }}', 'hcos': JSON.stringify(hcos) },
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            $('#maintenance_site_id').html('');

            var html = '<option value="0">Select Site</option>';

            $.each(data.sites, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+' ('+value.address+' )</option>';
            });

            $('#maintenance_site_id').append(html);
            $('#maintenance_site_id').prop('disabled',false);
            $('#maintenance_site_id').selectpicker('refresh');
            
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

      $("#maintenance_site_id").change(function(){
        
        if( $('#maintenance_site_id :selected').length > 0){
            var sites = [];

            $('#maintenance_site_id :selected').each(function(i, selected) {
                sites[i] = $(selected).val();
            });
        }

        $.ajax({
          type: 'POST',
          url: '{{ url('admin/maintenance/users/fetch/buildings') }}',
          data: { '_token' : '{{ csrf_token() }}', 'sites': JSON.stringify(sites) },
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            $('#maintenance_building_id').html('');

            var html = '<option value="0">Select Building</option>';

            $.each(data.buildings, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+'</option>';
            });

            $('#maintenance_building_id').append(html);
            $('#maintenance_building_id').prop('disabled',false);
            $('#maintenance_building_id').selectpicker('refresh');

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

      $("#maintenance_building_id").change(function(){
        
        var building_id = $("#maintenance_building_id").val();

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
                $('#maintenance_department_id').html('');

                var html = '<option value="0">Select Department</option>';

                $.each(data.departments, function(index, value) {
                    html += '<option value="'+value.id+'">'+value.name+'</option>';
                });

                $('#maintenance_department_id').append(html);
                $('#maintenance_department_id').prop('disabled',false);
                $('#maintenance_department_id').selectpicker('refresh');
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
