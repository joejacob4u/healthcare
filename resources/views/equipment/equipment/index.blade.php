@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Equipment')
@section('page_description','Manage equipments here')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

//put some help texts here

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
        <h3 class="box-title">Existing Equipments for <strong>{{session('building_name')}}</strong></h3>

        <div class="box-tools pull-right">
          <a href="{{url('equipment/create')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Equipment</a>
        </div>
      </div>
      <div class="box-body">
        <div class="pull-left"><a href="{{url('equipment/download')}}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-save"></span> Download</a></div>
        <br/>
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Serial Number</th>
                        <th>Room Number</th>
                        <th>Eq ID Number</th>
                        <th data-toggle="popover" title="USL Score" data-trigger="hover" data-content="{{$usl_text}}">USL Score</th>
                        <th data-toggle="popover" title="FCI#" data-trigger="hover" data-html="true" data-content="{{$fci_text}}">FCI #</th>
                        <th data-toggle="popover" title="EM Number" data-trigger="hover" data-content="{{$em_number_text}}">EM Number Score</th>
                        <th data-toggle="popover" title="EM Rating" data-trigger="hover" data-content="{{$em_rating_text}}">EM Rating Score</th>
                        <th data-toggle="popover" title="Adjusted EM Rating" data-trigger="hover" data-content="{{$adjusted_em_rating_text}}">Adjusted EM Rating Score</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Serial Number</th>
                        <th>Room Number</th>
                        <th>Eq ID Number</th>
                        <th>USL Score</th>
                        <th>FCI #</th>
                        <th>EM Number Score</th>
                        <th>EM Rating Score</th>
                        <th>Adjusted EM Rating Score</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($equipments as $equipment)
                    <tr>
                      <td>{{$equipment->name}}</td>
                      <td>{{$equipment->serial_number}}</td>
                      <td>{{$equipment->room->room_number}}</td>
                      <td>{{$equipment->identification_number}}</td>
                      <td><span class="label label-default">{{$equipment->USLScore()}} / 6</span></td>
                      <td><span class="label label-default">{{$equipment->FCINumber()}} / 0.300</span></td>
                      <td><span class="label label-default">{{$equipment->EMNumberScore()}}</span></td>
                      <td><span class="label label-default">{{$equipment->EMRatingScore()}}</span></td>
                      <td><span class="label label-default">{{$equipment->AdjustedEMRScore()}}</span></td>
                      <td>{{link_to('equipment/edit/'.$equipment->id,'Edit', ['class' => 'btn-xs btn-warning'] )}}</td>
                      <td>{{link_to('','Delete', ['class' => 'btn-xs btn-danger'] )}}</td>
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
