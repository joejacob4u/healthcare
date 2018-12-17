@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Baseline dates for '.$equipment->name)
@section('page_description','Manage baseline dates for equipment.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="{{url('equipment')}}">Equipment</a></li>
    <li>Baseline dates for {{$equipment->name}}</li>
</ol>

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Add Baseline Date</h3>

          <div class="box-tools pull-right">
          </div>

        </div>
        <div class="box-body">
          
            {!! Form::open(['url' => 'equipment/'.$equipment->id.'/baseline-dates']) !!}
            <div class="form-group">
                <div class="col-lg-8">
                    {!! Form::text('date', $value = '', ['class' => 'form-control','id' => 'date','placeholder' => 'Select Date']) !!}
                </div>
                <div class="col-lg-4">
                    <button class="btn btn-success" id="search-button"><span class="glyphicon glyphicon-add"></span> Add Baseline Date</button>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
        <!-- /.box-body -->
        <!-- /.box-footer-->
        <div class="box-footer">
          You can add inventories on a baseline date which in turn creates a work order for those inventories.
        </div>
      </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Baseline Dates for {{$equipment->name}}</h3>
        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Inventory</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Inventory</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($equipment->baselineDates as $baseline_date)
                    <tr>
                        <td>{{$baseline_date->date->toFormattedDateString()}}</td>
                        <td>{{link_to('equipment/'.$baseline_date->equipment->id.'/baseline-date/'.$baseline_date->id.'/inventory','Inventory', ['class' => 'btn-xs btn-info'] )}}</td>
                        <td>Delete</td>
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

    $("#date").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });


    </script>



@endsection
