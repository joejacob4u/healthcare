@extends('layouts.app')

@section('head')
@parent
<script src="{{ asset ("bower_components/simple-ajax-uploader/SimpleAjaxUploader.min.js") }}" type="text/javascript"></script>
@endsection
@section('page_title','Add a Building')
@section('page_description','add building here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add building for {{$site->name}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'sites/'.$site->id.'/buildings/add', 'class' => 'form-horizontal','files' => true]) !!}

            <fieldset>

              <div class="form-group">
                  {!! Form::label('name', 'Building Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $value = '', ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                  </div>
              </div>

              <!-- Phone -->
              <div class="form-group">
                  {!! Form::label('building_id', 'Building Id:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('building_id', $value = '', ['class' => 'form-control', 'placeholder' => 'id']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('accreditations', 'Accreditations', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('accreditations[]',$accreditations->prepend('Please select accreditations', '0'), $value = '', ['class' => 'form-control selectpicker','multiple' => true]) !!}
                  </div>
              </div>


              <div class="form-group">
                  {!! Form::label('occupancy_type', 'Occupancy Type:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('occupancy_type', $occupancy_types, Request::old('occupancy_type'), ['class' => 'form-control','placeholder' => 'Please select']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('ownership', 'Ownership Type:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('ownership', $ownership_types, Request::old('ownership'), ['class' => 'form-control','placeholder' => 'Please select']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('ownership_comments', 'Ownership Comments', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('ownership_comments', Request::old('ownership_comments'), ['class' => 'form-control']) !!}
                  </div>
              </div>


              <div class="form-group">
                  {!! Form::label('building_logo_image', 'Building Logo', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::file('building_logo_image', ['class' => 'form-control','id' => 'building_logo_image']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('building_pictures', 'Building Pictures', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                  <button type="button" class="btn btn-primary" name="building_images_btn" id="building_images_btn" disabled><span class="glyphicon glyphicon-open"></span> Upload Images</button>
                  <button type="button" class="btn btn-info" onclick="previewImages()"><span class="glyphicon glyphicon-picture"></span> View Images</button>
                  </div>
              </div>



                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('sites/'.$site->id.'/buildings', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Add Building', ['class' => 'btn btn-success pull-right'] ) !!}
                    </div>
                </div>

            </fieldset>
            {!! Form::hidden('building_img_dir', '', ['class' => 'form-control','id' => 'building_img_dir']) !!}
            {!! Form::close()  !!}
               </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <script>
        var uploader =  new ss.SimpleUpload({
                            button: 'building_images_btn', // HTML element used as upload button
                            url: '{{url('sites/buildings/upload/images')}}', // URL of server-side upload handler
                            name: 'buildingimages',
                            data: {'site_id' : {{$site->id}}};
                            multiple: true,
                            customHeaders: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                            onSubmit: function(filename, extension) {
                            dialog = bootbox.dialog({
                                    message: '<p class="text-center">Uploading file to server...</p>',
                                    closeButton: false
                                });
                            },
                            onComplete: function(filename, response) {
                            dialog.modal('hide');
                            $('#building_img_dir').val(response);
                            }
                        });

            function previewImages()
            {
                $.ajax({
                        type: 'POST',
                        url: '{{ asset('sites/buildings/images/fetch') }}',
                        data: { '_token' : '{{ csrf_token() }}','directory' : $('#building_img_dir').val()},
                        beforeSend:function()
                        {
                            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                        },
                        success:function(data)
                        {
                            console.log(data);
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


    </div>

@endsection
