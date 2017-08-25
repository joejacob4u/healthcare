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

    <div class="box box-solid box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Prequalify Delivery</h3>

        <div class="box-tools pull-right">
            <button class="btn btn-success" type="button" onclick="addEmail()"><span class="glyphicon glyphicon-plus"></span> Add E-Mail</button>
        </div>
      </div>
      <div class="box-body" id="email_box">
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
                {!! Form::textarea('acknowledgement_statement',null,['class' => 'form-control','id' => 'acknowledgement_statement']); !!}
            </div>
        </div>
        <div class="checkbox col-lg-10">
            <label><input type="checkbox" id="acknowledgement_statement_acknowledge" value="" checked>Prompt the User to Acknowledge</label>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer-->
    </div>

    <div class="box box-solid box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Welcome Email Message</h3>
      </div>
      <div class="box-body">
        <div class="form-group">
            {!! Form::label('welcome_message', 'Welcome Email Message', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::textarea('welcome_message',null,['class' => 'form-control','id' => 'welcome_message']); !!}
            </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer-->
    </div>

    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Welcome E-Mail Files</h3>

        <div class="box-tools pull-right">
            <button class="btn btn-success" onclick="addWelcomeFiles()" type="button"><span class="glyphicon glyphicon-plus"></span> Add Attachment</button>
        </div>
      </div>

      <div class="box-body" id="welcome_email_box">

      </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer-->
    </div>



    <button class="btn btn-success" type="button" onclick="savePrequalify()"><span class="glyphicon glyphicon-ok"></span> Save Prequalify Form</button>
      {!! Form::close()  !!}



    <script>
      var file_counter = 0;
      var requirement_counter = 0;
      var email_counter = 0;
      var welcome_email_counter = 0;
      var welcome_file_counter = 0;


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
              '<input type="hidden" name="file_path_'+file_counter+'" id="file_path_'+file_counter+'" value="">'+
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
          '<input type="hidden" name="file_input_type_'+file_counter+'" id="file_input_type_'+file_counter+'" value="file">'+
          '<input type="hidden" name="file_action_type_'+file_counter+'" id="file_action_type_'+file_counter+'" value="output">'+
      '</div>';


        $('#user_reference').append(html_code);

        var s3_url = '{{config('filesystems.disks.s3.url')}}';

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
              $('#file_path_'+file_counter).val(response);
              $('#file_path_'+file_counter+'_label').html(s3_url + response);
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
              '<textarea class="form-control" rows="3" id="requirement_description_'+requirement_counter+'" name="requirement_description_'+requirement_counter+'" file_number="'+requirement_counter+'"></textarea>'+
            '</div>'+
            '<div class="form-group col-xs-8">'+
              '<label><input type="checkbox" value="acknowledged" id="requirement_acknowledged_'+requirement_counter+'" name="requirement_acknowledged_'+requirement_counter+'" file_number="'+requirement_counter+'"> Required</label>'+
            '</div>'+
          '</div>'+
          '<div class="box-footer">'+
            '<button class="btn btn-danger btn-sm" onclick="removeRequirement('+requirement_counter+')"><span class="glyphicon glyphicon-remove"></span>Remove</button>'+
          '</div>'+
          '<input type="hidden" name="requirement_input_type_'+requirement_counter+'" id="requirement_input_type_'+requirement_counter+'" value="file" file_number="'+requirement_counter+'">'+
          '<input type="hidden" name="requirement_action_type_'+requirement_counter+'" id="requirement_action_type_'+requirement_counter+'" value="input" file_number="'+requirement_counter+'">'+

      '</div>';

        $('#user_requirement').append(html_code);

      }

      function addEmail()
      {
          email_counter++;
          var html_code = '<div class="box box-solid box-info" id="email_box_'+email_counter+'">'+
          '<div class="box-header with-border">'+
            '<h3 class="box-title">E-Mail '+email_counter+'</h3>'+
          '</div>'+
            '<div class="box-body">'+
              '<div class="form-group col-xs-8">'+
                '<label for="comment">E-Mail Address:</label>'+
                '<input class="form-control" type="email"  id="email_address_value_'+email_counter+'" name="email_address_value_'+email_counter+'" file_number="'+email_counter+'"></input>'+
              '</div>'+
            '</div>'+
            '<div class="box-footer">'+
              '<button class="btn btn-danger btn-sm" onclick="removeEmail('+email_counter+')"><span class="glyphicon glyphicon-remove"></span>Remove</button>'+
            '</div>'+
            '<input type="hidden" name="email_address_input_type_'+email_counter+'" id="email_address_input_type_'+email_counter+'" value="email" file_number="'+email_counter+'">'+
            '<input type="hidden" name="email_address_action_type_'+email_counter+'" id="email_address_action_type_'+email_counter+'" value="system" file_number="'+email_counter+'">'+
        '</div>';

        $('#email_box').append(html_code);
      }

      function addWelcomeFiles()
      {
        welcome_file_counter++;

        var html_code = '<div class="box box-solid box-success" id="welcome_file_box_'+welcome_file_counter+'">'+
        '<div class="box-header with-border">'+
          '<h3 class="box-title">Welcome File '+welcome_file_counter+'</h3>'+
        '</div>'+
          '<div class="box-body">'+
            '<div class="form-group col-xs-8">'+
              '<button type="button" class="btn btn-primary btn-sm" name="welcome_file_'+welcome_file_counter+'" id="welcome_file_'+welcome_file_counter+'"><span class="glyphicon glyphicon-upload"></span>Upload File</button>'+
              '<input type="hidden" name="welcome_file_path_'+welcome_file_counter+'" id="welcome_file_path_'+welcome_file_counter+'" value="">'+
            '</div>'+
            '<div class="form-group col-xs-12">'+
              '<label id="welcome_file_path_'+welcome_file_counter+'_label"></label>'+
            '</div>'+
          '</div>'+
          '<div class="box-footer">'+
            '<button class="btn btn-danger btn-sm" onclick="removeWelcomeFile('+welcome_file_counter+')"><span class="glyphicon glyphicon-remove"></span>Remove</button>'+
          '</div>'+
          '<input type="hidden" name="welcome_file_input_type_'+welcome_file_counter+'" id="welcome_file_input_type_'+welcome_file_counter+'" value="file">'+
          '<input type="hidden" name="welcome_file_action_type_'+welcome_file_counter+'" id="welcome_file_action_type_'+welcome_file_counter+'" value="email">'+
      '</div>';


        $('#welcome_email_box').append(html_code);

        var s3_url = '{{config('filesystems.disks.s3.url')}}';

        new ss.SimpleUpload({
            button: 'welcome_file_'+welcome_file_counter, // HTML element used as upload button
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
              $('#welcome_file_path_'+welcome_file_counter).val(response);
              $('#welcome_file_path_'+welcome_file_counter+'_label').html(s3_url + response);
            }
          });
      }

      function removeWelcomeFile(id)
      {
        $('#welcome_file_box_'+id).remove();
      }


      function savePrequalify()
      {
        var files = {};
        var requirements = {};
        var emails = {};
        var welcome_files = {};

        $( "textarea[id^='file_'],input[id^='file_']" ).each(function( index ) {

          if($( this ).attr('type') == 'checkbox')
          {
              if($( this ).is(':checked'))
              {
                files[$( this ).attr('name') ] = 1;
              }
              else
              {
                files[$( this ).attr('name') ] = 0;
              }
          }
          else
          {
            files[$( this ).attr('name') ] = $( this ).val();
          }
        });


        $( "textarea[id^='requirement_'],input[id^='requirement_']" ).each(function( index ) {

          if($( this ).attr('type') == 'checkbox')
          {
              if($( this ).is(':checked'))
              {
                requirements[$( this ).attr('name') ] = 1;
              }
              else
              {
                requirements[$( this ).attr('name') ] = 0;
              }
          }
          else
          {
            requirements[$( this ).attr('name') ] = $( this ).val();
          }
        });


        $( "input[id^='email_address_']" ).each(function( index ) {

            emails[$( this ).attr('name') ] = $( this ).val();
        });


        $( "input[id^='welcome_file_']" ).each(function( index ) {

            welcome_files[$( this ).attr('name') ] = $( this ).val();
        });

        var welcome_message = $('#welcome_message').val();




        var acknowledgement_statement = $('#acknowledgement_statement').val();
        var acknowledgement_statement_acknowledge = ($('#acknowledgement_statement_acknowledge').is(':checked')) ? 1 : 0;

        $.ajax({
              type: 'POST',
              url: '{{ asset('prequalify/configure') }}',
              dataType: "json",
              data: { '_token' : '{{ csrf_token() }}',
                      'files': JSON.stringify(files), 'requirements' : JSON.stringify(requirements),
                      'acknowledgement_statement' :  acknowledgement_statement, 'emails' : JSON.stringify(emails), 'welcome_message' : welcome_message,
                      'acknowledgement_statement_acknowledge' : acknowledgement_statement_acknowledge,'welcome_files' : JSON.stringify(welcome_files)
                    },
              beforeSend:function()
              {
                $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
              },
              success:function(data)
              {
                window.location = '/prequalify';
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
