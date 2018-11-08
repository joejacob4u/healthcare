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
        <h3 class="box-title">Capital Planning View for Equipments in <strong>{{session('building_name')}}</strong></h3>

        <div class="box-tools pull-right">
          <div class="pull-left"><a href="{{url('equipment/download')}}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-save"></span> Download</a></div>
        </div>
      </div>
      <div class="box-body">
                <table id="example" class="table table-striped" type="custom">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Asset Category</th>
                        <th>Description</th>
                        <th>Replacement Cost</th>
                        <th>USL Condition</th>
                        <th>FCI #</th>
                        <th>More Info</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Asset Category</th>
                        <th>Description</th>
                        <th>Replacement Cost</th>
                        <th>USL Condition</th>
                        <th>FCI #</th>
                        <th>More Info</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($equipments as $equipment)
                    <tr>
                      <td>{{$equipment->name}}</td>
                      <td>{{$equipment->category->name}}</td>
                      <td>{{$equipment->assetCategory->name}}</td>
                      <td>{{$equipment->description}}</td>
                      <td>{{$equipment->estimated_replacement_cost}}</td>
                      <td>{{$equipment->USLScore()}}</td>
                      <td>{{$equipment->FCINumber()}}</td>  
                      
                      @php
                        $html = '<strong>Estimated Deferred Maintenance Cost per Year : </strong> $'.$equipment->estimated_deferred_maintenance_cost;
                      @endphp

                      <td>{{link_to('#info-'.$equipment->id,'More Info', ['class' => 'btn-xs btn-primary','data-toggle' => 'popover','title' => 'More Info for '.$equipment->name,'data-placement' => 'left','data-trigger' => 'click','data-html' => "true",'data-content' => $html] )}}</td>
                    
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

      $('table').DataTable( {
        "order": [[ 5, "desc" ],[6,"desc"]]
    } );
  });
  </script>
@endsection
