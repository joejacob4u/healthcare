@extends('layouts.app')

@section('head')
@parent
<script src="{{ asset ("bower_components/simple-ajax-uploader/SimpleAjaxUploader.min.js") }}" type="text/javascript"></script>
@endsection
@section('content')
@section('page_title','Prequalify Form')
@section('page_description','Manage prequlaify forms here.')
@include('layouts.partials.success')
@include('layouts.partials.errors')
{!! Form::open(['url' => 'prequalify/configure', 'class' => 'form-horizontal','files' => true]) !!}
    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">User Reference Files</h3>

        <div class="box-tools pull-right">
            <button class="btn btn-success" onclick="addFiles()" type="button"><span class="glyphicon glyphicon-plus"></span> Add File</button>
        </div>
      </div>
      
      <div class="box-body" id="user_reference">
      </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer-->
    </div>

    <div class="box box-solid box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Required User Files</h3>

        <div class="box-tools pull-right">
            <button class="btn btn-success" type="button" onclick="addRequirement()"><span class="glyphicon glyphicon-plus"></span> Add Requirement</button>
        </div>
      </div>
      <div class="box-body" id="user_requirement">
      </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer-->
    </div>

    <div class="box box-solid box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Acknowledgement</h3>
      </div>
      <div class="box-body">
        <div class="form-group">
            {!! Form::label('acknowledgement_statement', 'Acknowledgement Statement', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::textarea('acknowledgement_statement',null,['class' => 'form-control']); !!}
            </div>
        </div>
        <div class="checkbox col-lg-10">
            <label><input type="checkbox" value="" checked>Prompt the User to Acknowledge</label>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer-->
    </div>
    <input type="submit" class="btn btn-success" value="Save"/>
      {!! Form::close()  !!}



    <script>
      var file_counter = 0;
      var requirement_counter = 0;

      function addFiles()
      {
        file_counter++;

        var html_code = '<div class="box box-solid box-success" id="file_box_'+file_counter+'">'+
        '<div class="box-header with-border">'+
          '<h3 class="box-title">File '+file_counter+'</h3>'+
        '</div>'+
          '<div class="box-body">'+
            '<div class="form-group col-xs-8">'+
              '<label for="comment">Description:</label>'+
              '<textarea class="form-control" rows="3" id="file_description_'+file_counter+'" name="file_description_'+file_counter+'"></textarea>'+
            '</div>'+
            '<div class="form-group col-xs-8">'+
              '<button type="button" class="btn btn-primary btn-sm" name="file_'+file_counter+'" id="file_'+file_counter+'"><span class="glyphicon glyphicon-upload"></span>Upload File</button>'+
              '<input type="hidden" name="file_'+file_counter+'_path" id="file_'+file_counter+'_path" value="">'+
            '</div>'+
            '<div class="form-group col-xs-12">'+
              '<label id="file_path_'+file_counter+'_label"></label>'+
            '</div>'+
            '<div class="form-group col-xs-8">'+
              '<label><input type="checkbox" value="acknowledged" name="file_acknowledged_'+file_counter+'" id="file_acknowledged_'+file_counter+'"> Acknowledgment Required</label>'+
            '</div>'+
          '</div>'+
          '<div class="box-footer">'+
            '<button class="btn btn-danger btn-sm" onclick="removeFile('+file_counter+')"><span class="glyphicon glyphicon-remove"></span>Remove</button>'+
          '</div>'+
      '</div>';


        $('#user_reference').append(html_code);

        new ss.SimpleUpload({
            button: 'file_'+file_counter, // HTML element used as upload button
            url: '{{url('prequalify/upload')}}', // URL of server-side upload handler
            name: 'uploadfile',
            customHeaders: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
            onSubmit: function(filename, extension) {
              dialog = bootbox.dialog({
                    message: '<p class="text-center">Uploading file to server...</p>',
                    closeButton: false
                });
            },         
            onComplete: function(filename, response) {
              dialog.modal('hide');
              $('#file_'+file_counter+'_path').val(response);
              $('#file_path_'+file_counter+'_label').html(response);
            }
          });        
      }

      function removeFile(id)
      {
        $('#file_box_'+id).remove();
      }

      function removeRequirement(id)
      {
        $('#requirement_box_'+id).remove();
      }

      function addRequirement()
      {
        requirement_counter++;

        var html_code = '<div class="box box-solid box-danger" id="requirement_box_'+requirement_counter+'">'+
        '<div class="box-header with-border">'+
          '<h3 class="box-title">Required User File '+requirement_counter+'</h3>'+
        '</div>'+
          '<div class="box-body">'+
            '<div class="form-group col-xs-8">'+
              '<label for="comment">Description:</label>'+
              '<textarea class="form-control" rows="3" id="requirement_description_'+requirement_counter+'"></textarea>'+
            '</div>'+
            '<div class="form-group col-xs-8">'+
              '<label><input type="checkbox" value="acknowledged" id="requirement_acknowledged_'+requirement_counter+'"> Required</label>'+
            '</div>'+
          '</div>'+
          '<div class="box-footer">'+
            '<button class="btn btn-danger btn-sm" onclick="removeRequirement('+requirement_counter+')"><span class="glyphicon glyphicon-remove"></span>Remove</button>'+
          '</div>'+
      '</div>';

        $('#user_requirement').append(html_code);

      }
    </script>



@endsection
