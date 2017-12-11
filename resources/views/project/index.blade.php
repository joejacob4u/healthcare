@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Project')
@section('page_description','Manage projects here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Projects</h3>
        <div class="box-tools pull-right">
          <a href="{{url('projects/general/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Project</a>
        </div>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Project</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($projects as $project)
                    <tr id="tr-{{$project->id}}">
                        <td class="project">{{$project->project_name}}</td>
                        <td>{!! link_to('projects/general/edit/'.$project->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteproject('.$project->id.')']) !!}</td>
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
    <div id="requirementsModal" class="modal fade" role="dialog">
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

        <!-- project Modal-->
    <div id="projectModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit project</h4>
          </div>
          <div class="modal-body">
            <label class="control-label col-sm-2" for="project">project:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="project" name="project" placeholder="Edit project">
              <input type="hidden"  name="project_id" id="project_id" value="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" onclick="editproject()">Edit</button>
          </div>
        </div>

      </div>
    </div>

    <!-- End project Modal-->


    <script>
      function showAccreditationRequirements(id)
      {
        $.ajax({
          type: 'POST',
          url: '{{ url('admin/accreditation/info') }}',
          data: { '_token' : '{{ csrf_token() }}', 'id': id },
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            $('#requirementsModal ul').html('');

            var html = '';

            $.each(data, function(index, value) {
                html += '<li><a href="accreditation-requirements/edit/'+value.id+'">'+value.name+'</a></li>';
            });

            $('#requirementsModal ul').append(html);

            $('#requirementsModal').modal('show');
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

      function editprojectModal(id)
      {
        $('#projectModal #project_id').val(id);
        $('#projectModal').modal('show');
          
      }

      function editproject()
      {
        var project = $('#projectModal #project').val();
        var project_id = $('#projectModal #project_id').val();

        $.ajax({
          type: 'POST',
          url: '{{ url('project/ranking-projects/edit') }}',
          data: { '_token' : '{{ csrf_token() }}', 'project_id': project_id, 'project': project },
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
              $('#projectModal').modal('hide');
              $('#tr-'+data.id+' .project').html(data.project);
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

      function deleteproject(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('project/ranking-projects/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'project_id': id},
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
