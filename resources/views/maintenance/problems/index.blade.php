@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Work Order Problems')
@section('page_description','Manage problems.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Problems for {{$trade->name}}</h3>
        </div>
        <div class="box-body">
            <form class="form-inline" role="form" method="POST" action="/admin/work-order/trades/{{$trade->id}}/problems">
                <div class="form-group">
                    <label for="name">Maintenance Trade Problem</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter trade problem">
                </div>
                <div class="form-group">
                    <label for="work_order_priority_id">Priority</label>
                    {!! Form::select('work_order_priority_id',$work_order_priorities->prepend('Please Select',0), $value = '', ['class' => 'form-control','id' => 'work_order_priority_id']) !!}
                </div>


                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
        <!-- /.box-body -->
      </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Maintenance Trade Problems for {{$trade->name}}</h3>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Priority</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Priority</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($trade->problems as $problem)
                    <tr id="tr-{{$problem->id}}">
                        <td>{{$problem->name}}</td>
                        <td>@if(!empty($problem->priority->name)){{$problem->priority->name}} @else Not Set @endif</td>
                        <td>{!! link_to('#','Edit',['class' => 'btn-xs btn-warning edit-btn','data-problem-id' => $problem->id,'data-name' => $problem->name, 'data-priority' => (!empty($problem->priority->name)) ? $problem->priority->id : 0]) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteProblem('.$problem->id.')']) !!}</td>
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

        <!-- Edit Modal -->
  <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Problem</h4>
        </div>
        <div class="modal-body">
          <form action="/admin/work-order/problems/save" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter trade">
            </div>
            <div class="form-group">
                <label for="priority">Priority:</label>
                {!! Form::select('work_order_priority_id',$work_order_priorities->prepend('Please Select',0), $value = '', ['class' => 'form-control','id' => 'work_order_priority_id']) !!}
            </div>
            <button type="submit" class="btn btn-success">Edit</button>
            {!! Form::hidden('problem_id','',['id' => 'problem_id']) !!}
            {!! csrf_field() !!}
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



    <script>

      function deleteProblem(problem_id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/work-order/problems/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'problem_id': problem_id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                        $('#tr-'+problem_id).remove();
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

      $('.edit-btn').click(function(){
          $('#editModal #name').val($(this).attr('data-name'));
          $('#editModal #problem_id').val($(this).attr('data-problem-id'));
          $('#editModal #priority').val($(this).attr('data-priority'));
          $('#editModal').modal('show');
      });


    </script>

@endsection
