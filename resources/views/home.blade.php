@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        @if(Auth::guard('admin')->check())
            <div class="jumbotron">
                <h3>Welcome {{Auth::guard('admin')->user()->name}} !</h3>
                <p>Logged as Master Admin</p>
            </div>
        @else
           <div class="jumbotron">
                <h3>Welcome {{Auth::user()->name}} !</h3>
                <p>To get started, select a HCO, Site and Building</p>
                <p><a data-toggle="modal" data-target="#accreditation_modal" href="#" class="btn btn-primary btn-lg">Start</a></p>
            </div>
        @endif
        </div>
    </div>
</div>
@endsection
