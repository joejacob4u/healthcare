@extends('layouts.app')

@section('head')
    <script src="{{ asset ("/bower_components/moment/moment.js") }}" type="text/javascript"></script>

@parent

@endsection
@section('page_title','ILSM Assessment for '.$ilsm_assessment->demandWorkOrder->identifier)
@section('page_description','Updated on '.$ilsm_assessment->updated_at->toFormattedDateString())

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="{{url('equipment/work-orders')}}#ilsm-assessments">ILSM Assessments</a></li>
    <li>ILSM Assessment for {{$ilsm_assessment->demandWorkOrder->identifier}}</li>
</ol>

@if(count($ilsm_assessment->demandWorkOrder->problem->eops) > 0)

<div class="callout callout-info">
    <h4>EOP</h4>

    @foreach($ilsm_assessment->demandWorkOrder->problem->eops as $eop)

    <a href="#" class="list-group-item active list-group-item-info">
        <h4>{{$eop->standardLabel->label}} - EOP : {{$eop->name}}</h4>
        <p>{{$eop->text}}</p>
    </a>

    @endforeach
</div>

@endif


@if(!empty($ilsm_assessment->ilsm_preassessment_question_answers))
    <div class="callout callout-warning">
        <h4>ILSM Pre Assessment  : (Status => @if($ilsm_assessment->demandWorkOrder->is_ilsm) ILSM Required @else No ILSM Required @endif, Completed By : {{$ilsm_assessment->preAssessmentUser->name}})</h4>
        @foreach($ilsm_assessment->ilsm_preassessment_question_answers as $key => $answer)
            <div class="row">
                <div class="col-sm-6">{{ \App\Equipment\IlsmPreassessmentQuestion::find($key)->question}}</div>
                <div class="col-sm-6">@if($answer) Yes @else No @endif</div>
            </div><br/>
        @endforeach
    </div>

@endif

@if(!empty($ilsm_assessment->ilsm_question_answers))
    <div class="callout callout-info">
        <button class="btn btn-success btn-sm pull-right"><span class="glyphicon glyphicon-ok"></span> Approve</button>
        <h4>ILSM Questions  : (Completed By : {{$ilsm_assessment->questionUser->name}})</h4>
        @foreach($ilsm_assessment->ilsm_question_answers as $key => $answer)
            <div class="row">
                @php $ilsm_question = \App\Equipment\IlsmQuestion::find($key); @endphp
                <div class="col-sm-6">{{ $ilsm_question->question}}</div>
                <div class="col-sm-6">@if($answer) <strong>Yes</strong> ({{$ilsm_question->ilsms->implode('label',',')}}) @else <strong>No</strong> @endif</div>
            </div><br/>
        @endforeach
    </div>
@else
    <div class="callout callout-danger">
        <h4>Next Step => Please fill out ILSM Question</h4>
            <div class="row">
                <center><a href="#" data-toggle="modal" data-target="#ilsm-question-modal" class="btn btn-link btn-lg"><span class="glyphicon glyphicon-list-alt"></span> Click for ILSM Questionnaire</a></center>
            </div><br/>
    </div>
@endif

    <!-- ILSM Question Modal -->
    <div class="modal fade" id="ilsm-question-modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ILSM Questionnaire</h4>
          </div>
          <div class="modal-body">
            <form action="/equipment/ilsm-assessment/ilsm-questions" method="post">
              @foreach($ilsm_questions as $question)
                <div class="form-group">
                    <label for="ilsm_question_{{$question->id}}">{{$question->question}}</label>
                    {!! Form::select('ilsm_question_answers['.$question->id.']', ['' => 'Please Select','1' => 'Yes','0' => 'No'], '', ['class' => 'form-control','id' => 'ilsm_question_answers_'.$question->id,'multiple' => false]); !!}
                </div>
              @endforeach

              {!! Form::hidden('ilsm_assessment_id', $ilsm_assessment->id,['id' => 'ilsm_assessment_id']) !!}


              <button type="submit" class="btn btn-success">Submit</button>
              {!! csrf_field() !!}
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>




  <script>


  </script>
@endsection
