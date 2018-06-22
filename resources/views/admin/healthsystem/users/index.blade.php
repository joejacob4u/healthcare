@extends('layouts.app')

@section('head')
@parent
@section('page_title','Health Care System Admins')
@section('page_description','Manage Health Care System Admins here.')

@endsection
@section('content')
@include('layouts.partials.success')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">System Admins</h3>

        <div class="box-tools pull-right">
          <a href="{{url('healthsystem/users/add')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add System Admin</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Phone</th>
                        <th>Health System</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>E-Mail</th>
                      <th>Phone</th>
                      <th>Health System</th>
                      <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->healthSystem->healthcare_system}}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteUser('.$user->id.')']) !!}</td>
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

    function deleteUser(id)
    {
        bootbox.confirm("Do you really want to delete?", function(result)
        {
          if(result){

            $.ajax({
              type: 'POST',
              url: '{{ asset('healthsystem/user/delete') }}',
              data: { '_token' : '{{ csrf_token() }}', 'id': id },
              beforeSend:function()
              {
                $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
              },
              success:function(data)
              {
                  if(data == 'true')
                  {
                    window.location = "{{url('healthsystem/user/delete')}}";
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
