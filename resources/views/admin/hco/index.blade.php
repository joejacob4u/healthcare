@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Health Card Organizations')
@section('page_description','Manage HCOs here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">HCO</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/hco/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add HCO</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>HCO ID #</th>
                        <th>HCO Name</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>HCO ID #</th>
                      <th>HCO Name</th>
                      <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($accreditations as $accreditation)
                    <tr>
                      <td>{{$accreditation->id}}</td>
                      <td>{{$accreditation->name}}</td>
                      <td>{!! link_to('#','Info',['class' => 'btn-xs btn-primary','onclick' => 'showAccreditationRequirements('.$accreditation->id.')']) !!}</td>
                      <td>{!! link_to('admin/accreditation/edit/'.$accreditation->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                      <td>{!! link_to('admin/accreditation/delete/'.$accreditation->id,'Delete',['class' => 'btn-xs btn-danger']) !!}</td>
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
    </script>

@endsection
