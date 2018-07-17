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
                  {!! Form::label('hco_id', 'HCO', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('hco_id',$healthsystem->hcos->pluck('facility_name','id')->prepend('Please select',0), $value = '', ['class' => 'form-control selectpicker']) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('site_id', 'Site', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('site_id',[], $value = '', ['class' => 'form-control selectpicker','disabled' => true,'id' => 'site_id']) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('building_id', 'Building', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('building_id[]',[], $value = '', ['class' => 'form-control selectpicker','disabled' => true,'id' => 'building_id','multiple' => true]) !!}
                  </div>
                </div>



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

    $("#hco_id").change(function(){
        
        var hco_id = $("#hco_id").val();

        $.ajax({
          type: 'POST',
          url: '{{ url('system-admin/accreditation/fetch/sites') }}',
          data: { '_token' : '{{ csrf_token() }}', 'hco_id': hco_id },
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            $('#site_id').html('');

            var html = '<option value="0">Select Site</option>';

            $.each(data.sites, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+' ('+value.address+' )</option>';
            });

            $('#site_id').append(html);
            $('#site_id').prop('disabled',false);
            $('#site_id').selectpicker('render');
            
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
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            $('#building_id').html('');

            var html = '<option value="0">Select Building</option>';

            $.each(data.buildings, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+'</option>';
            });

            $('#building_id').append(html);
            $('#building_id').prop('disabled',false);
            $('#building_id').selectpicker('render');

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
