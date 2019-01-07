@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Inventory for '.$baseline_date->equipment->name.' for baseline date '.$baseline_date->date->toFormattedDateString())
@section('page_description','Manage inventories here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="{{url('equipment')}}">Equipment</a></li>
    <li><a href="{{url('equipment/'.$baseline_date->equipment->id.'/baseline-dates')}}">{{$baseline_date->date->toFormattedDateString()}}</a></li>
    <li>Inventory</li>
</ol>

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
        <h3 class="box-title">Existing Inventory for {{$baseline_date->equipment->name}}</h3>
        <div class="box-tools pull-right">
          <a href="{{url('equipment/'.$baseline_date->equipment->id.'/baseline-date/'.$baseline_date->id.'/inventory/add')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add Inventory</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Serial Number</th>
                        <th data-toggle="popover" title="USL Score" data-trigger="hover" data-content="{{$usl_text}}">USL Score</th>
                        <th data-toggle="popover" title="FCI#" data-trigger="hover" data-html="true" data-content="{{$fci_text}}">FCI #</th>
                        <th data-toggle="popover" title="Adjusted EM Rating" data-trigger="hover" data-content="{{$adjusted_em_rating_text}}">Adjusted EM Rating Score</th>
                        <th>Equipment Risk Score</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Serial Number</th>
                        <th>USL Score</th>
                        <th>FCI #</th>
                        <th>Adjusted EM Rating Score</th>
                        <th>Equipment Risk Score</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($baseline_date->inventories->sortByDesc('created_at') as $inventory)
                    <tr id="inventory-{{$inventory->id}}">
                      <td>{{$inventory->name}}</td>
                      <td>{{$inventory->serial_number}}</td>
                      <td><span class="label label-default">{{$inventory->USLScore()}} / 6</span></td>
                      <td><span class="label label-default">{{$inventory->FCINumber()}} / 0.300</span></td>
                      <td><span class="label label-default">{{$inventory->AdjustedEMRScore()}}</span></td>
                      <td><span class="label label-default">{{$inventory->equipmentRiskScore()}}</span></td>
                      <td>{!! link_to('equipment/'.$inventory->baselineDate->equipment->id.'/baseline-date/'.$inventory->baselineDate->id.'/inventory/edit/'.$inventory->id,'Edit',['class' => 'btn-xs btn-warning','target' => '_blank']) !!}</td>
                      <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteInventory('.$inventory->id.')']) !!}</td>                             
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

        function deleteInventory(inventory_id)
        {
            bootbox.confirm("Do you really want to delete?", function(result)
            {
            if(result){

                $.ajax({
                type: 'POST',
                url: '{{ asset('equipment/inventory/delete') }}',
                data: { '_token' : '{{ csrf_token() }}', 'inventory_id': inventory_id },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    if(data.status == 'success')
                    {
                        $('#inventory-'+inventory_id).remove();
                    }
                    else {
                        bootbox.alert("Something went wrong, try again later");
                    }
                },
                error:function()
                {
                    // failed request; give feedback to user
                },
                complete: function(data)
                {
                    $('.overlay').remove();
                }
                });
            }
            });
        }


        </script>



@endsection
