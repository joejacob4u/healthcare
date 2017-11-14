@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">System User Prospects</h3>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Edit Role</th>
                        <th>Details</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Role</th>
                      <th>Edit Role</th>
                      <th>Details</th>
                      <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($users as $user)
                    <tr id="tr-{{$user->id}}">
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td class="role_name">{{$user->role->name}}</td>
                        <td>{!! link_to('#','Edit Role',['class' => 'btn-xs btn-primary','onclick' => 'getRole('.$user->id.')']) !!}</td>
                        <td>{!! link_to('users/prospects/details/'.$user->id,'Download Files',['class' => 'btn-xs btn-info','onclick' => 'prospectDetails('.$user->id.')']) !!}</td>
                        <td>{{$user->status}}</td>
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

        <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Contractors/Business Partner</h3>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Company</th>
                        <th>Details</th>
                        <th>Projects</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Company</th>
                      <th>Details</th>
                      <th>Projects</th>
                      <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($contract_users as $user)
                    <tr id="tr-{{$user->id}}">
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->corporation}}</td>
                        <td>{!! link_to('#','Download Files',['class' => 'btn-xs btn-info','onclick' => 'contractorProspectDetails('.$user->id.')']) !!}</td>
                        <td>Under Construction</td>
                        <td>@if($user->status == 1)  Active @else Disabled @endif</td>
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

        <!-- Start Modal-->
    <div id="roleModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Assign Role</h4>
          </div>
          <div class="modal-body">
            <select class="form-control" id="role_id">
            </select>
          </div>
          <input type="hidden" id="user_id" value="">
          <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="setUserRole()">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <!-- End Modal-->


    <script>
        function prospectDetails(user_id)
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('users/prospects/details/') }}',
                data: { '_token' : '{{ csrf_token() }}', 'user_id': user_id },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    // $('#requirementsModal ul').html('');

                    // var html = '';

                    // $.each(data, function(index, value) {
                    //     html += '<li><a href="accreditation-requirements/edit/'+value.id+'">'+value.name+'</a></li>';
                    // });

                    // $('#requirementsModal ul').append(html);

                    // $('#requirementsModal').modal('show');
                    console.log(data);
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

        function getRole(user_id)
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('users/prospects/get-role/') }}',
                data: { '_token' : '{{ csrf_token() }}', 'user_id': user_id },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    $('#roleModal select').html('');

                    var html = '';

                    $.each(data.roles, function(index, value) {
                        if(value.id == data.user_role)
                        {
                            html += '<option value="'+value.id+'" selected>'+value.name+'</option>';
                        }
                        else
                        {
                            html += '<option value="'+value.id+'">'+value.name+'</option>';
                        }
                    });

                    $('#roleModal select').append(html);
                    $('#roleModal #user_id').val(user_id);

                    $('#roleModal').modal('show');

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

        function setUserRole()
        {
            var user_id = $('#roleModal #user_id').val();
            var role_id = $('#roleModal #role_id').val();

            $.ajax({
                type: 'POST',
                url: '{{ url('users/prospects/save-role') }}',
                data: { '_token' : '{{ csrf_token() }}', 'user_id': user_id, 'role_id' : role_id },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    if(data.status == 'success')
                    {
                        $('#tr-'+user_id+' .role_name').html(data.role);
                        $('#roleModal').modal('hide');
                        bootbox.alert("User Role Changed.");
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
    </script>


@endsection
