@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','EOP Documentation - <strong>'.$building->name.'</strong>')
@section('page_description','Configure EOP Documentations here.')



@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<div class="callout callout-info">
    <h4>EOP : {{$eop->name}}</h4>
    <p>{{$eop->text}}</p>
</div>

<div class="callout callout-warning">
    <h4>EOP Upload Frequency : {{ ucfirst($eop->frequency) }}</h4>
    <p>{{ $eop->getNextDocumentUploadDate($building->id) }}</p>
</div>


    <div class="box">
      <div class="box-header with-border">
        <a data-toggle="collapse" href="#eop_form" class="btn btn-success"><span class="glyphicon glyphicon-open"></span> Upload EOP Document</a>
      </div>
      <div class="box-body collapse" id="eop_form">
      {!! Form::open(['url' => 'system-admin/accreditation/eop/document/upload']) !!}
            <div class="form-group">
                {!! Form::label('submission_date', 'Submission Date:', ['class' => 'control-label']) !!}
                {!! Form::date('submission_date', '', Request::old('submission_date'), ['class' => 'form-control','id' => 'submission_date']); !!}
            </div>
            <div class="form-group">
                {!! Form::label('document_path', 'Documents:', ['class' => 'control-label']) !!}
                {!! HTML::dropzone('document_path','accreditation/'.session('accreditation_id').'/building/'.$building->id.'/eop/'.$eop->id.'/'.strtotime('now'),'false') !!}
            </div>

            {!! Form::hidden('building_id',$building->id) !!}
            {!! Form::hidden('eop_id',$eop->id) !!}
            {!! Form::hidden('accreditation_id',session('accreditation_id')) !!}
            {!! Form::hidden('user_id',Auth::guard('system_user')->user()->id) !!}

              <button type="submit" class="btn btn-primary">Upload</button>
          {!! Form::close()  !!}

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
      </div>
      <!-- /.box-footer-->
    </div>

    <div class="box">
      <div class="box-header with-border">
        <h4>EOP Document History</h4>
      </div>
      <div class="box-body">
                <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Submitted Date</th>
                        <th>Submitted By</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Submitted Date</th>
                        <th>Submitted By</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($building->eopDocumentations as $document)
                    <tr id="tr-{{$document->id}}">
                        <td>{{$document->pivot->submission_date}}</td>
                        <td>{{ App\User::find($document->pivot->user_id)->name}}</td>
                        <td>{!! link_to('system-admin/accreditation/eop/document/edit/'.$document->id,'Edit Files',['class' => 'btn-xs btn-primary']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>


      </div>
      <!-- /.box-body -->
      <div class="box-footer">
      </div>
      <!-- /.box-footer-->
    </div>


@endsection
