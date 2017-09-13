@extends('layouts.app')

@section('head')
@parent
<script src="{{ asset ("bower_components/simple-ajax-uploader/SimpleAjaxUploader.min.js") }}" type="text/javascript"></script>

@section('page_title','Health System Prequalify Form')
@section('page_description','Fill out prequalify form here.')

@endsection
@section('content')
@include('layouts.partials.success')
<div class="box box-solid box-primary">
<div class="box-header with-border">
  <h3 class="box-title">Reference Files for Application</h3>
</div>

<div class="box-body" id="user_reference">
    @foreach($prequalify_form->where('input_type','file')->where('action_type','output') as $file)
    <div class="box box-solid box-success">
            <div class="box-header with-border">
              <h3 class="box-title">File</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" rows="3" placeholder="Enter ..." disabled>{{$file->description}} </textarea>
                </div>
              <div class="form-group">
                  <a href="{{url('contractor/prequalify/download/'.$file->id)}}" class="btn btn-primary"><span class="glyphicon glyphicon-download-alt"></span> Download File</a>
                </div>
                @if($file->is_required)
                  <div class="form-group">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox">I have downloaded and read the file
                      </label>
                    </div>
                  </div>
                @endif
            </div>
            <!-- /.box-body -->
          </div>
    @endforeach
</div>
<!-- /.box-body -->
<div class="box-footer">

</div>
<!-- /.box-footer-->
</div>

<div class="box box-solid box-warning">
<div class="box-header with-border">
  <h3 class="box-title">Required User Files</h3>

</div>
<div class="box-body" id="user_requirement">
  @foreach($prequalify_form->where('input_type','file')->where('action_type','input') as $file)
    <div class="box box-solid box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">File Requirement</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" rows="3" placeholder="Enter ..." disabled>{{$file->description}}</textarea>
              </div>
              <div class="form-group col-xs-8">
                <button type="button" class="btn btn-primary btn-sm" name="file_{{$file->id}}" id="file_{{$file->id}}"><span class="glyphicon glyphicon-upload"></span>Upload File</button>
                <input type="hidden" name="file_path_{{$file->id}}" id="file_path_{{$file->id}}" value="">
              </div>
              <div class="form-group col-xs-12">
              <label id="file_path_{{$file->id}}_label"></label>
            </div>
              <div class="form-group col-xs-8">
                <label> @if($file->is_required)<p class="bg-danger"> * This is required </p>@endif</label>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <script>
          $( document ).ready(function() {
            var file_id = '{{$file->id}}';
            var s3_url = '{{config('filesystems.disks.s3.url')}}';

              new ss.SimpleUpload({
                button: 'file_'+file_id, // HTML element used as upload button
                url: '{{url('contractor/prequalify/upload')}}', // URL of server-side upload handler
                name: 'uploadfile',
                data: {'healthsystem_id' : '{{$healthsystem_id}}'},
                customHeaders: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                onSubmit: function(filename, extension) {
                  dialog = bootbox.dialog({
                        message: '<p class="text-center">Uploading file to server...</p>',
                        closeButton: false
                    });
                },
                onComplete: function(filename, response) {
                  dialog.modal('hide');
                  $('#file_path_'+file_id).val(response);
                  $('#file_path_'+file_id+'_label').html(s3_url + response);
                }
            });

          });
          </script>
    @endforeach
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
@foreach($prequalify_form->where('input_type','textarea')->where('action_type','output') as $acknowledgement)
  <div class="form-group">
      {!! Form::label('acknowledgement_statement', 'Acknowledgement Statement', ['class' => 'col-lg-2 control-label']) !!}
      <div class="col-lg-10">
          {!! Form::textarea('acknowledgement_statement',$acknowledgement->value,['class' => 'form-control','id' => 'acknowledgement_statement','disabled' => true]); !!}
      </div>
  </div>
  <div class="checkbox col-lg-10">
      <label><input type="checkbox" id="acknowledgement_statement_acknowledge" value="" @if($acknowledgement->is_required) checked @endif disabled>I acknowledge the above</label>
  </div>
  @endforeach
</div>
<!-- /.box-body -->
<div class="box-footer">

</div>
<!-- /.box-footer-->
</div>

<button class="btn btn-success" type="button" onclick="submitPrequalify()"><span class="glyphicon glyphicon-ok"></span> Submit </button>
      {!! Form::close()  !!}

<script>

function submitPrequalify()
{
    $.ajax({
      type: "POST",
      url: "{{url('contractor/prequalify/apply')}}",
      data: {'_token' : '{{ csrf_token() }}','healthsystem_id' : '{{$healthsystem_id}}'},
      beforeSend:function()
      {
        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
      },
      success:function(data)
      {
        window.location = '{{url('contractor/prequalify')}}';
      },
      error:function()
      {
        // failed request; give feedback to user
      },
      complete: function(data)
      {
          $('.overlay').remove();
      }

    });
}

</script>



@endsection
