@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add Assessment')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="{{url('assessments')}}">Assessments</a></li>
    <li>Add</li>
</ol>


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add Assessment</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'assessments', 'class' => 'form-horizontal']) !!}

            <fieldset>

                <div class="form-group">
                    {!! Form::label('building_department_id', 'Department:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('building_department_id', $departments->prepend('Please Select',''), Request::old('building_department_id'), ['class' => 'form-control selectpicker','id' => 'building_department_id']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('assessment_section_id', 'Assessment Section:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('assessment_section_id', $assessment_sections->prepend('Please Select',''), Request::old('assessment_section_id'), ['class' => 'form-control selectpicker','id' => 'assessment_section_id']) !!}
                    </div>
                </div>

                 <div class="form-group">
                    {!! Form::label('assessment_checklist_type_id', 'Checklist Type:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('assessment_checklist_type_id', [], Request::old('assessment_checklist_type_id'), ['class' => 'form-control selectpicker','id' => 'assessment_checklist_type_id']) !!}
                    </div>
                </div>

                {!! Form::hidden('building_id', session('building_id'),['id' => 'building_id']) !!}
                {!! Form::hidden('assessment_status_id', 1,['id' => 'assessment_status_id']) !!}
                {!! Form::hidden('user_id', Auth::user()->id,['id' => 'user_id']) !!}


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! Form::submit('Add Assessment', ['class' => 'btn btn-success pull-right'] ) !!}
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

    $('.date').flatpickr({
         enableTime: true,
         dateFormat: 'Y-m-d H:i:S',
         altInput: true,
         altFormat: 'M j, Y h:i K',
    });

    $('#assessment_section_id').change(function(){

        if($(this).val())
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('assessment/fetch-checklist-types') }}',
                data: { '_token' : '{{ csrf_token() }}','assessment_section_id' : $(this).val()},
                beforeSend:function(){},
                success:function(data)
                {
                    $('#assessment_checklist_type_id').html('');

                    var html = '<option value="0">Select Checklist Type</option>';


                    $.each(data.checklist_types, function(index, value) {
                        html += '<option value="'+value.id+'">'+value.name+'</option>';
                    });

                    $('#assessment_checklist_type_id').append(html);
                    $('#assessment_checklist_type_id').selectpicker('refresh');

                },
                complete:function(){}
            });
        }

    });


    </script>

@endsection
