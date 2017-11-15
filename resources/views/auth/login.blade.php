@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@section('page_title','User Login')
@section('page_description','Users login here')
@include('layouts.partials.errors')
@include('layouts.partials.success')

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">System User Login</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ url('/login') }}">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox"> Remember Me
                  </label>
                </div>
                {{ csrf_field() }}
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
          </div>
    </div>

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Contractor Login</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{url('contractors/login')}}" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox"> Remember Me
                  </label>
                </div>
              </div>
              <!-- /.box-body -->
              {{ csrf_field() }}

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
          </div>
    </div>
</div>

    <a href="{{ url('forgot/password') }}">I forgot my password</a><br>
    <a href="{{ url('prospects/register') }}" class="text-center">New Prospect? Join here.</a><br>


<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>

@endsection
