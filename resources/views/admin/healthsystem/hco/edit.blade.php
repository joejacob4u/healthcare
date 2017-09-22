@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit HCO Info for {{$healthsystem->healthcare_system}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/healthsystem/'.$healthsystem->id.'/hco/edit/'.$hco->id, 'class' => 'form-horizontal']) !!}

            <fieldset>

                <!-- Email -->
                <div class="form-group">
                    {!! Form::label('facility_name', 'Facility Name:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('facility_name', $value = $hco->facility_name, ['class' => 'form-control', 'placeholder' => 'Facility Name']) !!}
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    {!! Form::label('address', 'Address:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::textarea('address', $value = $hco->address, ['class' => 'form-control', 'placeholder' => 'address','rows' => 3]) !!}
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('hco_id', 'HCO ID', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('hco_id', $value = $hco->hco_id, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                  {!! Form::label('is_need_state', 'Certification of Need State', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('is_need_state',['0' => 'No', '1' => 'Yes'], $hco->is_need_state, ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('hco_logo_image', 'HCO Logo', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::file('hco_logo_image', ['class' => 'form-control','id' => 'hco_logo_image']) !!}
                  </div>
              </div>

              @if(strlen($hco->hco_logo) > 0)
                <img src="{{Storage::disk('s3')->url($hco->hco_logo)}}" class="img-rounded" alt="" width="304" height="236">
             @endif



                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('admin/healthsystem/'.$healthsystem->id.'/hco', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        <button type="button" onclick="deleteHCO('{{$hco->id}}')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                        {!! Form::submit('Update HCO Client', ['class' => 'btn btn-success pull-right'] ) !!}
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

    function deleteHCO(id)
    {
        bootbox.confirm("Do you really want to delete?", function(result)
        {
          if(result){

            $.ajax({
              type: 'POST',
              url: '{{ asset('admin/healthsystem/hco/delete') }}',
              data: { '_token' : '{{ csrf_token() }}', 'id': id },
              beforeSend:function()
              {
                $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
              },
              success:function(data)
              {
                  if(data == 'true')
                  {
                    window.location = "{{url('admin/healthsystem/'.$healthsystem->id.'/hco')}}";
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
