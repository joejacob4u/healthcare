@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@section('page_title','Users')
@section('page_description','Add users here.')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'users/add', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->

                <div class="form-group">
                    {!! Form::label('name', 'Admin Name', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('name', $value = null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email', ['class' => 'col-lg-2 control-label']) !!}
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
                    {!! Form::label('address', 'Address', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::textarea('address',null,['class' => 'form-control']); !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('role_id', 'Role:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('role_id', $roles, Request::old('role_id'), ['class' => 'form-control','placeholder' => 'Please select']) !!}
                    </div>
                </div>
                  <!-- Email -->

                {!! Form::hidden('status', 'active'); !!}

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('users', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
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

@endsection
