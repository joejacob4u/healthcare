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
                <div class="col-lg-4">
                    {!! Form::text('date', Request::old('date'), ['class' => 'form-control','id' => 'date','placeholder' => 'Select Date']) !!}
                </div>
                <div class="col-lg-4">
                    {!! Form::select('user_id', $users->prepend('Select Assignee',0), Request::old('user_id'), ['class' => 'form-control','id' => 'user_id']); !!}
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
                        <th>User</th>
                        <th>Inventory</th>
                        <th>Work Orders</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Inventory</th>
                        <th>Work Orders</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($equipment->baselineDates->sortByDesc('date') as $baseline_date)
                    <tr id="baseline-date-{{$baseline_date->id}}">
                        <td>{{$baseline_date->date->toFormattedDateString()}}</td>
                        <td>{{$baseline_date->user->name}}</td>
                        <td>{{link_to('equipment/'.$baseline_date->equipment->id.'/baseline-date/'.$baseline_date->id.'/inventory','Inventory ('.$baseline_date->inventories->count().')', ['class' => 'btn-xs btn-info'] )}}</td>
                        <td>{{$baseline_date->workOrders->where('building_id',session('building_id'))->count()}}</td>
                        <td>{{link_to('#','Delete', ['class' => 'btn-xs btn-danger','onclick' => 'deleteBaselineDate('.$baseline_date->id.')'] )}}</td>
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

        function deleteBaselineDate(baseline_date_id)
        {
            bootbox.confirm("Do you really want to delete?", function(result)
            {
            if(result){

                $.ajax({
                type: 'POST',
                url: '{{ asset('equipment/baseline-date/delete') }}',
                data: { '_token' : '{{ csrf_token() }}', 'baseline_date_id': baseline_date_id },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    if(data.status == 'success')
                    {
                        $('#baseline-date-'+baseline_date_id).remove();
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
