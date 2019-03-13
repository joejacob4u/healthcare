@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add Maintenance Asset Category')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="{{url('facility-maintenance/drawings')}}">Drawings</a></li>
    <li>Add Drawing</li>
</ol>


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add Facility Maintenance Drawing</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => '/facility-maintenance/drawings', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'Drawing Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', Request::old('name'), ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
                  </div>
              </div>

                <!-- Phone -->
                <div class="form-group">
                    {!! Form::label('facility_maintenance_drawing_category_id', 'Category:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!! Form::select('facility_maintenance_drawing_category_id', $categories->prepend('Please select',''), Request::old('facility_maintenance_drawing_category_id'), ['class' => 'form-control']) !!}
                    </div>
                </div>


              <div class="form-group">
                  {!! Form::label('description', 'Description:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('description', Request::old('description'), ['class' => 'form-control', 'placeholder' => 'Description','rows' => '4']) !!}
                  </div>
              </div>

                <div class="form-group">
                    {!! Form::label('date', 'Document Date:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('date', Request::old('date'), ['class' => 'date form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('attachment_dir', 'Attachments:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! HTML::dropzone('attachment_dir','fm/drawings/'.session('building_id').'/'.time(),'false','true') !!}
                    </div>
                </div>


                {!! Form::hidden('building_id', session('building_id'),['id' => 'building_id']) !!}
                {!! Form::hidden('user_id', auth()->user()->id,['id' => 'user_id']) !!}


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! Form::submit('Add Drawing', ['class' => 'btn btn-success pull-right'] ) !!}
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

    $(".date").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });


    </script>

@endsection
