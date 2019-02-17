@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','ILSMS')
@section('page_description','Manage ilsms trades.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add ILSM</h3>
        </div>
        <div class="box-body">
            <form class="form" role="form" method="POST" action="{{url('admin/ilsms')}}">
                <div class="form-group">
                    <label for="name">ILSM Label</label>
                    <input type="text" class="form-control" name="label" id="label" placeholder="Enter label">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    {!! Form::textarea('description', '', ['class' => 'form-control','id' => 'description','rows' => 3]); !!}
                </div>

                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
        <!-- /.box-body -->
      </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Maintenance Trades</h3>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Description</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Label</th>
                        <th>Description</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($ilsms as $ilsm)
                    <tr id="tr-{{$ilsm->id}}">
                        <td>{{$ilsm->label}}</td>
                        <td>{{$ilsm->description}}</td>
                        <td>{!! link_to('#','Edit',['class' => 'btn-xs btn-warning edit-btn','data-ilsm-id' => $ilsm->id,'data-label' => $ilsm->label, 'data-description' => $ilsm->description]) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteIlsm('.$ilsm->id.')']) !!}</td>
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

        <!-- Edit Modal -->
  <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit ILSM</h4>
        </div>
        <div class="modal-body">
            <form class="form" role="form" method="POST" action="{{url('admin/ilsms/edit')}}">
                <div class="form-group">
                    <label for="label">ILSM Label</label>
                    <input type="text" class="form-control" name="label" id="label" placeholder="Enter label">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    {!! Form::textarea('description', '', ['class' => 'form-control','id' => 'description','rows' => 3]); !!}
                </div>

                {!! Form::hidden('ilsm_id', 'val',['id' => 'ilsm_id']) !!}

                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


    <script>

      function deleteIlsm(ilsm_id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/ilsms/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'ilsm_id': ilsm_id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                      if(data.status == 'success')
                      {
                          $('#tr-'+ilsm_id).remove();
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

      $('.edit-btn').click(function(){
          $('#editModal #label').val($(this).attr('data-label'));
          $('#editModal #description').val($(this).attr('data-description'));
          $('#editModal #ilsm_id').val($(this).attr('data-ilsm-id'));
          $('#editModal').modal('show');
      });

    </script>

@endsection
