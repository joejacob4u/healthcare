@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','EOP Documentation - <strong>'.$building->name.'</strong>')
@section('page_description','Configure EOP Documentations here.')

<div class="callout callout-info">
    <h4>EOP : {{$eop->name}}</h4>
    <p>{{$eop->text}}</p>
</div>

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
    <div class="box">
      <div class="box-header with-border">
        Upload eop document.
      </div>
      <div class="box-body">
      {!! Form::open(['url' => 'system-admin/accreditation/'.$accreditation->id.'/accr-requirements/']) !!}
            <div class="form-group">
                {!! Form::label('submission_date', 'Submission Date:', ['class' => 'control-label']) !!}
                {!! Form::date('submission_date', '', Request::old('submission_date'), ['class' => 'form-control','id' => 'submission_date']); !!}
            </div>
            <div class="form-group">
                {!! Form::label('document_path', 'Documents:', ['class' => 'control-label']) !!}
                {!! HTML::dropzone('document_path',$project->project_photos_directory,'true') !!}
            </div>

              <button type="submit" class="btn btn-primary">Search</button>
          {!! Form::close()  !!}

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>

@endsection
