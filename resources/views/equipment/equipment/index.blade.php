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
                        <th>Baseline Date</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Baseline Date</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($equipments as $equipment)
                    <tr id="tr-{{$equipment->id}}">
                      <td>{{$equipment->name}}</td>
                      <td>{{link_to('equipment/'.$equipment->id.'/baseline-dates/','Baseline Dates', ['class' => 'btn-xs btn-info'] )}}</td>
                      <td>{{link_to('equipment/edit/'.$equipment->id,'Edit', ['class' => 'btn-xs btn-warning'] )}}</td>
                      <td>{{link_to('#','Delete', ['class' => 'btn-xs btn-danger','onclick' => 'deleteEquipment('.$equipment->id.')'] )}}</td>
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

        function deleteEquipment(equipment_id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('equipment/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'id': equipment_id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                      if(data.status == 'success')
                      {
                          $('#tr-'+equipment_id).remove();
                      }
                    },
                    complete:function()
                    {
                        $('.overlay').remove();
                    },
                    error:function()
                    {
                        // failed request; give feedback to user
                    }
                });
             } 
          });

      }


  </script>


@endsection
