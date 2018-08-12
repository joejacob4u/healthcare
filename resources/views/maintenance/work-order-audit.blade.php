@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Work Order Audit')
@section('page_description','Manage work order audits here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Work Order Audit</h3>
        </div>
        <div class="box-body">
            <form class="form-inline" role="form" method="POST" action="/admin/maintenance/work-order-audit">
                <div class="form-group">
                    <label for="name">Work Order Audit</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter work order audit">
                </div>

                <div class="form-group">
                <label for="score">Score:</label>
                    <select class="form-control" name="score">
                        <option value="">Please Select</option>
                        <option value="1">Yes (1)</option>
                        <option value="0">No (0)</option>
                        <option value="-1">N/A</option>
                    </select>
                </div>

                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
        <!-- /.box-body -->
      </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Work Order Audits</h3>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Score</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Score</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($work_order_audits as $work_order_audit)
                    <tr id="tr-{{$work_order_audit->id}}">
                        <td>{{$work_order_audit->name}}</td>
                        @if($work_order_audit->score == 0)
                            <td>No ({{$work_order_audit->score}})</td>
                        @endif
                        @if($work_order_audit->score == 1)
                            <td>Yes ({{$work_order_audit->score}})</td>
                        @endif
                        @if($work_order_audit->score == -1)
                            <td>N/A ({{$work_order_audit->score}})</td>
                        @endif
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteWorkOrderAudit('.$work_order_audit->id.')']) !!}</td>
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

      function deleteWorkOrderAudit(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/maintenance/work-order-audit/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'id': id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                        $('#tr-'+id).remove();
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
