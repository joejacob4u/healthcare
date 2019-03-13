@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Facility Maintenance Drawings')
@section('page_description','Manage Facility Maintenance Drawings here')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Drawings for Facility Maintenance</h3>
        <div class="box-tools pull-right">
          <a href="{{url('facility-maintenance/drawings/create')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add Drawing</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>User</th>
                        <th>Date</th>
                        <th>Attachment</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>User</th>
                        <th>Date</th>
                        <th>Attachment</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($drawings as $drawing)
                    <tr id="tr-{{$drawing->id}}">
                        <td>{{$drawing->name}}</td>
                        <td>{{$drawing->category->name}}</td>
                        <td>{{$drawing->user->name}}</td>
                        <td>{{$drawing->date->toFormattedDateString()}}</td>
                        <td>{!! link_to('#','Attachments',['class' => 'attachment btn-xs btn-primary', 'data-attachments' => json_encode(\Storage::disk('s3')->files($drawing->attachment_dir))]) !!}</td>
                        <td>{!! link_to('facility-maintenance/drawings/'.$drawing->id.'/edit','Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteDrawing('.$drawing->id.')']) !!}</td>
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

    <div class="modal fade" id="attachment-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Attachments</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>



    <script>

    var s3_url = '{{env("S3_URL")}}';

    $('.attachment').click(function(){

      $('#attachment-modal .modal-body').html('');

      var list_html = '<li class="list-group-item disabled">Attachments</li>';

       var attachments = JSON.parse($(this).attr('data-attachments'));

        $.each( attachments, function( index, value ){
            list_html += '<li class="list-group-item"><a target="_blank" href="'+s3_url+value+'">'+value.substring(value.lastIndexOf('/')+1)+'</a></li>';
        });

        $('#attachment-modal .modal-body').html('<ul class="list-group">'+list_html+'</ul>');

        $('#attachment-modal').modal('show');
    });


      function deleteDrawing(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('facility-maintenance/drawings/delete') }}',
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
