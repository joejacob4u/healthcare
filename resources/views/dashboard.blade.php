@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Dashboard')
@section('page_description','')

@section('content')

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

    
   <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Findings</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin" id="findings_table" type="yajra">
                  <thead>
                  <tr>
                    <th class="col-md-6">Description</th>
                    <th class="col-md-2">Building</th>
                    <th class="col-md-2">Status</th>
                    <th class="col-md-2">View</th>
                  </tr>
                  </thead>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
          </div>

             <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">My Findings</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin" id="my_findings_table" type="yajra">
                  <thead>
                  <tr>
                    <th class="col-md-6">Description</th>
                    <th class="col-md-2">Building</th>
                    <th class="col-md-2">Status</th>
                    <th class="col-md-2">View</th>
                  </tr>
                  </thead>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
          </div>


<script>

$('#findings_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '{{url('dashboard/fetch/findings')}}',
        type: "POST",
        data: function (data) {
            data._token = '{{ csrf_token() }}'
        }
    },
    columns: [
        {data: 'description', name: 'description'},
        {data: 'building', name: 'buildings.name'},
        {data: 'status', name: 'status'},
        {data: 'view', name: 'view', searchable: false},
    ]
});

$('#my_findings_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '{{url('dashboard/fetch/my-findings')}}',
        type: "POST",
        data: function (data) {
            data._token = '{{ csrf_token() }}'
        }
    },
    columns: [
        {data: 'description', name: 'description'},
        {data: 'building', name: 'buildings.name'},
        {data: 'status', name: 'status'},
        {data: 'view', name: 'view', searchable: false},
    ]
});





</script>
@endsection