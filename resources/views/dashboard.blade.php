@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Dashboard')
@section('page_description','')

@section('content')
@if($findings->count() != 0)
@if(!empty(session('building_id')))

<h4>Findings for HCO : <strong>{{ session('hco_name') }}</strong></h4>

<div class="row">
  <div class="col-md-12">
    <div class="info-box bg-green">
            <span class="info-box-icon"><i class="ion ion-ios-checkmark-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Compliant Findings</span>
              <span class="info-box-number">{{ $findings->where('status','compliant')->count() }}</span>

              <div class="progress">
                <div class="progress-bar" style="width: <?php echo number_format($findings->where('status','compliant')->count() / $findings->count() * 100, 2 ) . '%'; ?>"></div>
              </div>
              <span class="progress-description">
                    {{ $findings->where('status','compliant')->count() }} / {{$findings->count()}}
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
  </div>
</div>

<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $findings->where('status','pending_verification')->count() }}</h3>

              <p>Pending Verification</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-timer-outline"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner">
              <h3>{{$findings->where('status','issues_corrected_verify')->count()}}</h3>

              <p>Issues Corrected - Verify</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-list-outline"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$findings->where('status','initial')->count()}}</h3>

              <p>Initial Findings</p>
            </div>
            <div class="icon">
              <i class="ion ion-compose"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$findings->where('status','non-compliant')->count()}}</h3>

              <p>Non - Compliant</p>
            </div>
            <div class="icon">
              <i class="ion ion-alert-circled"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>



@else


<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$no_of_hcos}}</h3>

              <p>HCO</p>
            </div>
            <div class="icon">
              <i class="ion ion-network"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$no_of_users}}</h3>

              <p>Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$no_of_sites}}</h3>

              <p>Sites</p>
            </div>
            <div class="icon">
              <i class="ion ion-grid"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$no_of_buildings}}</h3>

              <p>Buildings</p>
            </div>
            <div class="icon">
              <i class="ion ion-social-buffer-outline"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      @endif
      @else

      No findings yet!

      @endif

    @endsection