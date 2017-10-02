@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">System Users</h3>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Details</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Details</th>
                      <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
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
        <h3 class="box-title">Contractors</h3>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Details</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Details</th>
                      <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($contract_users as $user)
                    <tr>
                        <td>{{$user->user->name}}</td>
                        <td>{{$user->user->email}}</td>
                        <td>{{$user->user->phone}}</td>
                        <td>{!! link_to('#','Download Files',['class' => 'btn-xs btn-info','onclick' => 'prospectDetails('.$user->id.')']) !!}</td>
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

        <!-- Start Modal-->
    <div id="detailsModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Accreditation Requirements</h4>
          </div>
          <div class="modal-body">
            <ul></ul>
          </div>
          <div class="modal-footer">
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
    </script>


@endsection
