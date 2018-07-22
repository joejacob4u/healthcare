@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Maintenance Shifts')
@section('page_description','Manage maintenance shifts.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Maintenance Shifts</h3>
            <div class="box-tools pull-right">
                <a href="{{url('admin/maintenance/shifts/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Maintenance Shift</a>
            </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>HCO</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>HCO</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($shifts as $shift)
                    <tr id="tr-{{$shift->id}}">
                        <td>{{$shift->name}}</td>
                        <td>{{$shift->hco->facility_name}}</td>
                        <td>{{$shift->start_time}}</td>
                        <td>{{$shift->end_time}}</td>
                        <td>{!! link_to('admin/maintenance/shifts/edit/'.$shift->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
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

      function toggleUserState(user_id,state)
      {
          bootbox.confirm("Are you sure ?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/maintenance/user/toggle_state') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'user_id': user_id, 'state': state},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                        if(state == 'disable')
                        {
                            $('#td-'+user_id).removeClass('btn-danger');
                            $('#td-'+user_id).addClass('btn-success');
                            $('#td-'+user_id).text('Enable');
                        }
                        else
                        {
                            $('#td-'+user_id).removeClass('btn-success');
                            $('#td-'+user_id).addClass('btn-danger');
                            $('#td-'+user_id).text('Disable');
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
