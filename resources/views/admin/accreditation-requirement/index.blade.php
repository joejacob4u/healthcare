@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Accreditation Requirements')
@section('page_description','Manage accreditation requirements here.')

@section('content')
@include('layouts.partials.success')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Accreditation Requirements</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/accreditation-requirements/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Requirement</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Accreditation Requirement</th>
                        <th>Info</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Id</th>
                      <th>Accreditation Requirement</th>
                      <th>Info</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($accreditation_requirements as $accreditation_requirement)
                    <tr>
                      <td>{{$accreditation_requirement->id}}</td>
                      <td>{{$accreditation_requirement->name}}</td>
                      <td>{!! link_to('#','Info',['class' => 'btn btn-warning btn-xs','onclick' => 'showStandardLabels('.$accreditation_requirement->id.')']) !!}</td>
                      <td><a href="{{url('admin/accreditation-requirements/edit/'.$accreditation_requirement->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>
                      <td>{!! link_to('admin/accreditation-requirements/delete/'.$accreditation_requirement->id,'Delete',['class' => 'btn btn-danger btn-xs']); !!}</td>
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

    <div id="standardLabelsModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Standard Labels</h4>
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

    <script>
    function showStandardLabels(id)
    {
      $.ajax({
        type: 'POST',
        url: '{{ url('admin/accreditation-requirements/info') }}',
        data: { '_token' : '{{ csrf_token() }}', 'id': id },
        beforeSend:function()
        {
          $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        },
        success:function(data)
        {
          console.log(data);
          $('#standardLabelsModal ul').html('');

          var html = '';

          $.each(data, function(index, value) {
              html += '<li><a href="standard-label/edit/'+value.id+'">'+value.name+'</a></li>';
          });

          $('#standardLabelsModal ul').append(html);

          $('#standardLabelsModal').modal('show');
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
