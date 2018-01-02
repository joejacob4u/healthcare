@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Approval Level Leaders')
@section('page_description','Manage Approval Level Leaders.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Approval Level Leaders</h3>
        <div class="box-tools pull-right">
          <a href="{{url('workflows/approval-level-leaders/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Approval Level Leaders</a>
        </div>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Title of Leader</th>
                        <th>Signing Level of Leader</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Title of Leader</th>
                        <th>Signing Level of Leader</th>
                        <th>Edit</th>
                        <th>Delete</th>

                    </tr>
                </tfoot>
                <tbody>
                  @foreach($approval_level_leaders as $approval_level_leader)
                    <tr id="tr-{{$approval_level_leader->id}}">
                        <td>{{$approval_level_leader->title}}</td>
                        <td>{{$approval_level_leader->signing_level_amount}}</td>
                        <td>{!! link_to('workflows/approval-level-leaders/edit/'.$approval_level_leader->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteApprovalLevelLeader('.$approval_level_leader->id.')']) !!}</td>
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

      function deleteApprovalLevelLeader(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('workflows/approval-level-leaders/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'approval_level_leader_id': id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                        $('#tr-'+data).remove();
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
