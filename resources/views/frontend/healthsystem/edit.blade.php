@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in Healthcare System Info</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'healthsystem/edit/'.$healthsystem->id, 'class' => 'form-horizontal','files' => true]) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('healthcare_system', 'Healthcare System:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('healthcare_system', $value = $healthsystem->healthcare_system, ['class' => 'form-control', 'placeholder' => 'Healthcare System']) !!}
                  </div>
              </div>
                <!-- Email -->
                <div class="form-group">
                    {!! Form::label('admin_name', 'Admin Name', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('admin_name', $value = $healthsystem->admin_name, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('admin_email', 'Admin Email', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('admin_email', $value = $healthsystem->admin_email, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('admin_phone', 'Admin Phone', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('admin_phone', $value = $healthsystem->admin_phone, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('state', 'State', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('state', States::whereCountryCode('US')->pluck('name','name'),$healthsystem->state,['class' => 'form-control']); !!}
                    </div>
                </div>

                <div class="form-group">
                  {!! Form::label('healthsystem_logo_image', 'Health System Logo', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::file('healthsystem_logo_image', ['class' => 'form-control','id' => 'healthsystem_logo_image']) !!}
                  </div>
              </div>

              @if(strlen($healthsystem->healthsystem_logo) > 0)
                <img src="{{Storage::disk('s3')->url($healthsystem->healthsystem_logo)}}" class="img-rounded" alt="" width="304" height="236">
             @endif





                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('healthsystem', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        <button type="button" onclick="deleteHealthSystem('{{$healthsystem->id}}')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                        {!! Form::submit('Update Healthcare System', ['class' => 'btn btn-success pull-right'] ) !!}
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

    function deleteHealthSystem(id)
    {
        bootbox.confirm("Do you really want to delete?", function(result)
        {
          if(result){

            $.ajax({
              type: 'POST',
              url: '{{ asset('healthsystem/delete') }}',
              data: { '_token' : '{{ csrf_token() }}', 'id': id },
              beforeSend:function()
              {
                $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
              },
              success:function(data)
              {
                  if(data == 'true')
                  {
                    window.location = "{{url('healthsystem')}}";
                  }
                  else {
                    bootbox.alert("Something went wrong, try again later");
                  }
              },
              error:function()
              {
                // failed request; give feedback to user
              },
              complete: function(data)
              {
                  $('.overlay').remove();
              }
            });
          }
        });
    }

    </script>


@endsection
