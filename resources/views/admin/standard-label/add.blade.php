@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add Standard Label')
@section('page_description','Fill in form below.')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in Standard Label</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/standard-label/add', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('label', 'Label:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('label', $value = null, ['class' => 'form-control', 'placeholder' => 'label']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('text', 'Text:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('text', $value = null, ['class' => 'form-control', 'placeholder' => 'Text']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('description', 'Description:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('description', $value = null, ['class' => 'form-control', 'placeholder' => 'description']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('accreditation', 'Accreditation:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('accreditation_id[]', $accreditations, '', ['class' => 'form-control selectpicker','multiple' => 'true','id' => 'accreditation_id']); !!}
                  </div>
              </div>

                <div class="form-group">
                    {!! Form::label('accreditation_requirement_id', 'Accreditation Requirement:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('accreditation_requirement_id', [], '', ['class' => 'form-control selectpicker','id' => 'accreditation_requirement_id']); !!}
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('admin/standard-label','Cancel',['class' => 'btn btn-warning']) !!}
                        {!! Form::submit('Add Standard Label', ['class' => 'btn btn-success pull-right'] ) !!}
                    </div>
                </div>

            </fieldset>

            {!! Form::close()  !!}
               </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer-->
    </div>

    <script>

    $( "#accreditation_id" ).change(function() {
            $.ajax({
                type: 'POST',
                url: '{{ url('admin/standard-label/fetch/multiple/accreditation-requirements') }}',
                data: { '_token' : '{{ csrf_token() }}', 'accreditations': JSON.stringify($(this).val()) },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    $('#accreditation_requirement_id').html('');

                    var html = '<option value="0">Select Requirement</option>';

                    $.each(data.accreditation_requirements, function(index, value) {
                        html += '<option value="'+value.id+'">'+value.name+'</option>';
                    });

                    $('#accreditation_requirement_id').append(html);
                    $('#accreditation_requirement_id').selectpicker('refresh');
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

    });

    </script>

@endsection
