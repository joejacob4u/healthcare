@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in HCO Info</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/hco/edit/'.$hco->id, 'class' => 'form-horizontal']) !!}

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
                        {!! Form::textarea('address', $value = $hco->address, ['class' => 'form-control', 'placeholder' => 'address']) !!}
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('hco_id', 'HCO ID', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('hco_id', $value = $hco->hco_id, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('healthsystem_id', 'Health System', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('healthsystem_id', $healthcare_systems,$hco->healthsystem_id,['class' => 'form-control']); !!}
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('admin/hco', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
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
              url: '{{ asset('admin/hco/delete') }}',
              data: { '_token' : '{{ csrf_token() }}', 'id': id },
              beforeSend:function()
              {
                $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
              },
              success:function(data)
              {
                  if(data == 'true')
                  {
                    window.location = "{{url('admin/hco')}}";
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
