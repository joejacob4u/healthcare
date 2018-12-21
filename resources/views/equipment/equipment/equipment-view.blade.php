@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Equipment')
@section('page_description','Manage equipment inventory here')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

@php


 $usl_text = "Useful Service Life (This score is from 1-6. A score of 6 is the worst)";

 $fci_text = "The Facility Cost Index is from 0.001 to 0.300 and higher.<br/><br/> 
                        0.011 to 0.072 has 76% or more useful service life remaining<br/>
                        0.073 to 0.147 has 51% to 75% useful service life remaining<br/>
                        0.148 to 0.225 has 25% to 50% useful service life remaining<br/>
                        0.226 to 0.270 has 10% to 24% useful service life remaining<br/>
                        0.271 to 0.300 has 9% to 0% useful service life remaining<br/>
                        Higher than 0.300 has spent its full useful service life and is in the negative";

  $em_number_text = "Equipment Management Number (A score of 12 and higher is high risk. The highest score possible is 20. A score of 20 is the worst)";

  $em_rating_text = "Equipment Management Rating (A score of 1 to 30, whereas 30 is the worst score)";

  $adjusted_em_rating_text = "This is a score that takes into account the mission criticality of the equipment. A score between 1% and 100%, whereas 100% is the worst score to have.";


  @endphp


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Equipments for <strong>{{session('building_name')}}</strong></h3>

        <div class="box-tools pull-right">
          <div class="pull-left"><a href="{{url('equipment/download')}}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-save"></span> Download</a></div>
        </div>
      </div>
      <div class="box-body">
                <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Inventory</th>
                        <th>Equipment</th>
                        <th>Category</th>
                        <th>Asset Category</th>
                        <th data-toggle="popover" title="USL Score" data-trigger="hover" data-content="{{$usl_text}}">USL Score</th>
                        <th data-toggle="popover" title="FCI#" data-trigger="hover" data-html="true" data-content="{{$fci_text}}">FCI #</th>
                        <th data-toggle="popover" title="EM Number" data-trigger="hover" data-content="{{$em_number_text}}">EM Number Score</th>
                        <th data-toggle="popover" title="EM Rating" data-trigger="hover" data-content="{{$em_rating_text}}">EM Rating Score</th>
                        <th data-toggle="popover" title="Adjusted EM Rating" data-trigger="hover" data-content="{{$adjusted_em_rating_text}}">Adjusted EM Rating Score</th>
                        <th>Capital Planning</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Inventory</th>
                        <th>Equipment</th>
                        <th>Category</th>
                        <th>Asset Category</th>
                        <th data-toggle="popover" title="USL Score" data-trigger="hover" data-content="{{$usl_text}}">USL Score</th>
                        <th data-toggle="popover" title="FCI#" data-trigger="hover" data-html="true" data-content="{{$fci_text}}">FCI #</th>
                        <th data-toggle="popover" title="EM Number" data-trigger="hover" data-content="{{$em_number_text}}">EM Number Score</th>
                        <th data-toggle="popover" title="EM Rating" data-trigger="hover" data-content="{{$em_rating_text}}">EM Rating Score</th>
                        <th data-toggle="popover" title="Adjusted EM Rating" data-trigger="hover" data-content="{{$adjusted_em_rating_text}}">Adjusted EM Rating Score</th>
                        <th>Capital Planning</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($equipments as $equipment)
                    @foreach($equipment->inventories as $inventory)
                    <tr>
                      <td>{{$inventory->name}} ({{link_to('#','info', ['class' => 'btn-link info','data-equipment' => json_encode($inventory->equipment),'data-inventory' => json_encode($inventory)] )}})</td>
                      <td>{{$inventory->equipment->name}}</td>
                      <td>{{$equipment->category->name}}</td>
                      <td>{{$inventory->equipment->assetCategory->name}}</td>
                      <td><span class="label label-default">{{$inventory->USLScore()}} / 6</span></td>
                      <td><span class="label label-default">{{$inventory->FCINumber()}} / 0.300</span></td>
                      <td><span class="label label-default">{{$inventory->EMNumberScore()}}</span></td>
                      <td><span class="label label-default">{{$inventory->EMRatingScore()}}</span></td>
                      <td><span class="label label-default">{{$inventory->AdjustedEMRScore()}}</span></td>
                      <td>{{link_to('','Planning', ['class' => 'btn-xs btn-primary planning','data-estimated-replacement-cost' => $inventory->estimated_replacement_cost,'data-estimated-deferred-maintenance-cost' => $inventory->estimated_deferred_maintenance_cost] )}}</td>
                    </tr>
                    @endforeach
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

    <!-- Planning Modal -->
  <div class="modal fade" id="planning_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Capital Planning</h4>
        </div>
        <div class="modal-body">
          <ul class="list-group">
            <li class="list-group-item">Estimated Replacement Cost <span id="estimated_replacement_cost" class="badge"></span></li>
            <li class="list-group-item">Estimated Deferred Maintenance Cost <span id="estimated_deferred_maintenance_cost" class="badge"></span></li> 
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- End of Planning Modal -->

  <!-- Info Modal -->

  <div class="modal fade" id="info_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Info</h4>
        </div>
        <div class="modal-body">
          <div class="list-group">
            
            <a href="#" class="list-group-item">
              <h4 class="list-group-item-heading">Manufacture</h4>
              <p class="list-group-item-text" id="manufacturer"></p>
            </a>

            <a href="#" class="list-group-item">
              <h4 class="list-group-item-heading">Model Number</h4>
              <p class="list-group-item-text" id="model_number"></p>
            </a>

            <a href="#" class="list-group-item">
              <h4 class="list-group-item-heading">Serial Number</h4>
              <p class="list-group-item-text" id="serial_number"></p>
            </a>

            <a href="#" class="list-group-item">
              <h4 class="list-group-item-heading">Identification Number</h4>
              <p class="list-group-item-text" id="identification_number"></p>
            </a>

            <a href="#" class="list-group-item">
              <h4 class="list-group-item-heading">Utilization</h4>
              <p class="list-group-item-text" id="utilization"></p>
            </a>

            <a href="#" class="list-group-item">
              <h4 class="list-group-item-heading">Equipment Description</h4>
              <p class="list-group-item-text" id="description"></p>
            </a>

            <a href="#" class="list-group-item">
              <h4 class="list-group-item-heading">Equipment Preventive Maintenance Procedure</h4>
              <p class="list-group-item-text" id="preventive_maintenance_procedure"></p>
            </a>

            <a href="#" class="list-group-item">
              <h4 class="list-group-item-heading">Freqency</h4>
              <p class="list-group-item-text" id="frequency"></p>
            </a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- End of Info Modal -->


  <script>
  $(document).ready(function(){
      $('[data-toggle="popover"]').popover(); 
  });

  $('.planning').click(function(){
    $('#estimated_replacement_cost').html('$'+$(this).attr('data-estimated-replacement-cost'));
    $('#estimated_deferred_maintenance_cost').html('$'+$(this).attr('data-estimated-deferred-maintenance-cost'));
    $('#planning_modal').modal('show');
  });

  $('.info').click(function(){
    var equipment_data = JSON.parse($(this).attr('data-equipment'));
    var inventory_data = JSON.parse($(this).attr('data-inventory'));

    $('#manufacturer').html(equipment_data.manufacturer);
    $('#model_number').html(equipment_data.model_number);
    $('#utilization').html(equipment_data.utilization+'%');
    $('#preventive_maintenance_procedure').html(equipment_data.preventive_maintenance_procedure);
    $('#frequency').html(equipment_data.frequency);
    $('#serial_number').html(inventory_data.serial_number);
    $('#identification_number').html(inventory_data.identification_number);
    $('#info_modal').modal('show');
  });


  </script>
@endsection
