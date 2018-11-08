@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Equipment')
@section('page_description','Manage equipments here')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Risk Assessment View for Equipments in <strong>{{session('building_name')}}</strong></h3>

        <div class="box-tools pull-right">
          <div class="pull-left"><a href="{{url('equipment/download')}}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-save"></span> Download</a></div>
        </div>
      </div>
      <div class="box-body">
                <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Asset Category</th>
                        <th>Description</th>
                        <th>Redundancy</th>
                        <th>Equipment Risk Calculation</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Asset Category</th>
                        <th>Description</th>
                        <th>Redundancy</th>
                        <th>Equipment Risk Calculation</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($equipments as $equipment)
                    <tr>
                      <td>{{$equipment->name}}</td>
                      <td>{{$equipment->category->name}}</td>
                      <td>{{$equipment->assetCategory->name}}</td>
                      <td>{{$equipment->description}}</td>
                      <td>{{$equipment->redundancy->name}}</td>
                      
                      @if($equipment->EMNumberScore() > 11)
                        <td><small class="label bg-red">High Risk ({{$equipment->EMNumberScore()}}) / 20</small></td>
                      @else
                        <td><small class="label bg-green">Low Risk ({{$equipment->EMNumberScore()}}) / 20</small></td>
                      @endif
                      
                    </tr>

                  @endforeach
                </tbody>
            </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>

  <script>
  $(document).ready(function(){
      $('[data-toggle="popover"]').popover(); 
  });
  </script>
@endsection
