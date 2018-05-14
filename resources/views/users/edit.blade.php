@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@section('page_title','Users')
@section('page_description','Edit user here.')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'users/edit/'.$user->id, 'class' => 'form-horizontal']) !!}

            <fieldset>

                <div class="form-group">
                    {!! Form::label('name', 'Admin Name', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('email', $user->email, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('phone', 'Phone', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('phone', $user->phone, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('address', 'Address', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::textarea('address',$user->address,['class' => 'form-control']); !!}
                    </div>
                </div>

                @if($user->role_id == 2)

                <div class="form-group">
                    {!! Form::label('role_id', 'Role:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('role_id', ['2' => 'System Admin'], $user->role_id, ['class' => 'form-control','readonly' => true]) !!}
                    </div>
                </div>

                @else

                <div class="form-group">
                    {!! Form::label('role_id', 'Role:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('role_id', $roles, $user->role_id, ['class' => 'form-control','placeholder' => 'Please select']) !!}
                    </div>
                </div>

                @endif

                <div class="form-group">
                    {!! Form::label('is_verifier', 'Allowed to verify documents and action plans', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('is_verifier', ['0' => 'No','1' => 'Yes'], $user->is_verifier, ['class' => 'form-control','placeholder' => 'Please select']) !!}
                    </div>
                </div>  

                {!! Form::hidden('status', $user->status); !!}

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('users/', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        <button type="button" onclick="deleteUser('{{$user->id}}')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                        {!! Form::submit('Edit User', ['class' => 'btn btn-success pull-right'] ) !!}
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

    function deleteUser(id)
    {
        bootbox.confirm("Do you really want to delete?", function(result)
        {
          if(result){

            $.ajax({
              type: 'POST',
              url: '{{ asset('users/delete') }}',
              data: { '_token' : '{{ csrf_token() }}', 'id': id },
              beforeSend:function()
              {
                $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
              },
              success:function(data)
              {
                  if(data == 'true')
                  {
                    window.location = "{{url('/users')}}";
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
