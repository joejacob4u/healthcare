@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Maintenance Requirements')
@section('page_description','Manage maintenance requirements here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Maintenance Requirements</h3>
        </div>
        <div class="box-body">
            <form class="form-inline" role="form" method="POST" action="/admin/equipment/maintenance-requirement">
                <div class="form-group">
                    <label for="name">Maintenance Requirements</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter maintenance requirement">
                </div>

                <div class="form-group">
                    <label for="name">Score</label>
                    <input type="text" class="form-control" name="score" id="score" placeholder="score">
                </div>

                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
        <!-- /.box-body -->
      </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Maintenance Requirements</h3>

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
                  @foreach($maintenance_requirements as $maintenance_requirement)
                    <tr id="tr-{{$maintenance_requirement->id}}">
                        <td>{{$maintenance_requirement->name}}</td>
                        <td>{{$maintenance_requirement->score}}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteMaintenanceRequirement('.$maintenance_requirement->id.')']) !!}</td>
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

      function deleteMaintenanceRequirement(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/equipment/maintenance-requirement/delete') }}',
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
