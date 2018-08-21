@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Equipment Users')
@section('page_description','Manage equipment users here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Equipment Users</h3>
        </div>
        <div class="box-body">
            <form class="form-inline" role="form" method="POST" action="/admin/biomed/equipment-users">
                <div class="form-group">
                    <label for="name">Equipment Utility</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter equipment user">
                </div>

                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
        <!-- /.box-body -->
      </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Equipment Users</h3>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Equipment User</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Equipment Users</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($equipment_users as $equipment_user)
                    <tr id="tr-{{$equipment_user->id}}">
                        <td>{{$equipment_user->name}}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteEquipmentUser('.$equipment_user->id.')']) !!}</td>
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

      function deleteEquipmentUser(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/biomed/equipment-users/delete') }}',
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
