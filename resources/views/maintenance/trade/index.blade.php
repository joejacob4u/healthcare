@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Work Order Trades')
@section('page_description','Manage work order trades.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Work Order Trade</h3>
        </div>
        <div class="box-body">
            <form class="form-inline" role="form" method="POST" action="/admin/work-order/trades">
                <div class="form-group">
                    <label for="name">Work Order Trade</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter trade">
                </div>
                <div class="form-group">
                    <label for="system_tier_id">System Tier</label>
                    {!! Form::select('system_tier_id',$system_tiers->prepend('Please select',0), $value = '', ['class' => 'form-control','id' => 'system_tier_id']) !!}
                </div>

                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
        <!-- /.box-body -->
      </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Maintenance Trades</h3>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>System Tier</th>
                        <th>Problems</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>System Tier</th>
                        <th>Problems</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($trades as $trade)
                    <tr id="tr-{{$trade->id}}">
                        <td>{{$trade->name}}</td>
                        <td>@if($trade->system_tier_id != 0) {{$trade->systemTier->name}} @else <p class="text-danger">Not set</p> @endif</td>
                        <td>{!! link_to('admin/work-order/trades/'.$trade->id.'/problems','Problems',['class' => 'btn-xs btn-primary']) !!}</td>
                        <td>{!! link_to('#','Edit',['class' => 'btn-xs btn-warning edit-btn','data-trade-id' => $trade->id,'data-name' => $trade->name, 'data-system-tier-id' => $trade->system_tier_id]) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteTrade('.$trade->id.')']) !!}</td>
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
          <h4 class="modal-title">Edit Trade</h4>
        </div>
        <div class="modal-body">
          <form action="/admin/work-order/trades/save" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter trade">
            </div>
            <div class="form-group">
                <label for="system_tier_id">System Tier:</label>
                {!! Form::select('system_tier_id',$system_tiers->prepend('Please select',0), $value = '', ['class' => 'form-control','id' => 'system_tier_id']) !!}
            </div>
            <button type="submit" class="btn btn-success">Edit</button>
            {!! Form::hidden('trade_id','',['id' => 'trade_id']) !!}
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

      function deleteTrade(trade_id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/work-order/trades/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'trade_id': trade_id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                        $('#tr-'+trade_id).remove();
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
          $('#editModal #trade_id').val($(this).attr('data-trade-id'));
          $('#editModal #system_tier_id').val($(this).attr('data-system-tier-id'));
          $('#editModal').modal('show');
      });

    </script>

@endsection
