@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
<div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">About Prospect</h3>
            <div class="box-tools pull-right">
              <a href="{{url('admin/healthsystem/prospects')}}" type="button" class="btn btn-block btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

          </div>
          <!-- /.box-header -->


          <div class="box-body">
            <strong><i class="fa fa-address-book" aria-hidden="true"></i> Name</strong>

            <p class="text-muted">
              {{$prospect_user->user->name}}
            </p>

            <hr>

            <strong><i class="fa fa-user" aria-hidden="true"></i> Title</strong>

            <p class="text-muted">{{$prospect_user->title}}</p>

            <hr>

            <strong><i class="fa fa-envelope-o" aria-hidden="true"></i> E-Mail</strong>

            <p class="text-muted">{{$prospect_user->user->email}}</p>

            <hr>

            <strong><i class="fa fa-phone" aria-hidden="true"></i> Phone</strong>

            <p class="text-muted">{{$prospect_user->user->phone}}</p>

            <hr>

            <strong><i class="fa fa-map-marker" aria-hidden="true"></i> Address</strong>

            <p class="text-muted">{{$prospect_user->user->address}}</p>

            <hr>

            <strong><i class="fa fa-building" aria-hidden="true"></i> Corporation</strong>

            <p class="text-muted">{{$prospect_user->corporation}}</p>

            <hr>

            <strong><i class="fa fa-handshake-o" aria-hidden="true"></i> Partnership</strong>

            <p class="text-muted">{{$prospect_user->partnership}}</p>

            <hr>

            <strong><i class="fa fa-circle" aria-hidden="true"></i> Sole Prop</strong>

            <p class="text-muted">{{$prospect_user->sole_prop}}</p>

            <hr>

            <strong><i class="fa fa-gavel" aria-hidden="true"></i> Company Owner</strong>

            <p class="text-muted">{{$prospect_user->company_owner}}</p>

            <hr>

            <strong><i class="fa fa-hashtag" aria-hidden="true"></i> Contract License Number</strong>

            <p class="text-muted">{{$prospect_user->contract_license_number}}</p>

            <hr>

            <strong><i class="fa fa-bars"></i> Trades</strong>

            <p>
              @foreach($prospect_user->trades as $trade)
                <span class="label label-primary">$trade->name</span>
              @endforeach
            </p>

            <hr>

          <!-- /.box-body -->
        </div>

@endsection
