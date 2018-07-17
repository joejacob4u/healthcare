@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Maintenance Users')
@section('page_description','Manage maintenance users.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Maintenance Users</h3>
            <div class="box-tools pull-right">
                <a href="{{url('admin/maintenance/users/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Maintenance User</a>
            </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Phone</th>
                        <th>Buildings</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Phone</th>
                        <th>Buildings</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($users as $user)
                    <tr id="tr-{{$user->id}}">
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>@foreach($user->buildings as $building) {{$building->name}} , @endforeach</td>
                        <td>{!! link_to('#','Disable',['class' => 'btn-xs btn-danger','onclick' => 'disableUser('.$user->id.')']) !!}</td>
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

      function deleteTrade(trade_id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/maintenance/trades/delete') }}',
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

    </script>

@endsection
