@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
           <div class="jumbotron">
                <h3>Welcome {{Auth::user()->name}} !</h3>
                <p>To get started, select a hco,site and building</p>
                <p><a data-toggle="modal" data-target="#accreditation_modal" href="#" class="btn btn-primary btn-lg">Start</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
