@extends('layouts.app')

@section('head')
    <script src="{{ asset ("/bower_components/moment/moment.js") }}" type="text/javascript"></script>

@parent

@endsection
@section('page_title','ILSM Assessment for '.$ilsm_assessment->work_order->identifier)
@section('page_description','Updated on '.$ilsm_assessment->updated_at->toFormattedDateString())

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="{{url('equipment/work-orders')}}#ilsm-assessments">ILSM Assessments</a></li>
    <li>ILSM Assessment for {{$ilsm_assessment->work_order->identifier}}</li>
</ol>

  @if($ilsm_assessment->ilsm_assessment_status_id == 7)
    <div class="callout callout-success">
      <h4>ILSM Assessment Completed and Compliant (Verified By : {{$ilsm_assessment->signOffUser->name}})</h4>
    </div>
  @endif

  @if($ilsm_assessment->ilsm_assessment_status_id == 6)

    <div class="callout callout-success">
      <h4>ILSM Checklist Completed - Awaiting Close Out</h4>
      <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ilsm-signoff-modal"><span class="glyphicon glyphicon-check"></span> Sign Off</button>  
    </div>
  @endif



@if($ilsm_assessment->work_order->work_order_type == 'App\Equipment\DemandWorkOrder')
  @if(count($ilsm_assessment->work_order->problem->eops) > 0)

  <div class="callout callout-info">
      <h4>EOP</h4>

      @foreach($ilsm_assessment->work_order->problem->eops as $eop)

      <a href="#" class="list-group-item active list-group-item-info">
          <h4>{{$eop->standardLabel->label}} - EOP : {{$eop->name}}</h4>
          <p>{{$eop->text}}</p>
      </a>

      @endforeach
  </div>

  @endif
@endif



@if($ilsm_assessment->work_order->work_order_type == 'App\Equipment\PreventiveMaintenanceWorkOrder')
  @if(count($ilsm_assessment->work_order->equipment->assetCategory->eops) > 0)

  <div class="callout callout-info">
      <h4>EOP</h4>

      @foreach($ilsm_assessment->work_order->equipment->assetCategory->eops as $eop)

      <a href="#" class="list-group-item active list-group-item-info">
          <h4>{{$eop->standardLabel->label}} - EOP : {{$eop->name}}</h4>
          <p>{{$eop->text}}</p>
      </a>

      @endforeach
  </div>

  @endif
@endif




@if(!empty($ilsm_assessment->ilsm_preassessment_question_answers))
    <div class="callout callout-warning">
        <h4>ILSM Pre Assessment  : (Status => @if($ilsm_assessment->work_order->is_ilsm) ILSM Required @else No ILSM Required @endif, Completed By : {{$ilsm_assessment->preAssessmentUser->name}})</h4>
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

      @if(!empty($ilsm_assessment->ilsm_approve_user_id))
            <h4 class="pull-right">Approved By :{{$ilsm_assessment->ilsmQuestionApprovalUser->name}}</h4>
      @else
            <button data-toggle="modal" data-target="#ilsm-question-approve-modal" class="btn btn-success btn-sm pull-right"><span class="glyphicon glyphicon-ok"></span> Approve</button>
      @endif
        <h4>ILSM Questions  : (Completed By : {{$ilsm_assessment->questionUser->name}})</h4>
        @php $ilsm_ids = []; @endphp
        @foreach($ilsm_assessment->ilsm_question_answers as $key => $answer)
            <div class="row">
                @php $ilsm_question = \App\Equipment\IlsmQuestion::find($key); if($answer) foreach($ilsm_question->ilsms as $ilsm): array_push($ilsm_ids, $ilsm->id); endforeach  @endphp
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


@if(isset($ilsm_ids) and !empty($ilsm_ids))

    <div class="box box-info collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title">ILSM Reference (Expand to see above {{count(array_unique($ilsm_ids))}} applicable ilsm descriptions)</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="expand"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
          <div class="table-responsive">
            <table class="table no-margin">
              <thead>
              <tr>
                <th>ILSM</th>
                <th>Description</th>
              </tr>
              </thead>
              <tbody>
                @php $ilsms = \App\Equipment\Ilsm::whereIn('id',$ilsm_ids)->get(); @endphp
                @foreach($ilsms as $ilsm)
                <tr>
                  <td>{{$ilsm->label}}</td>
                  <td>{{$ilsm->description}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix" style="">
        </div>
        <!-- /.box-footer -->
      </div>
  @endif


  @if(!empty($ilsm_assessment->ilsm_approve_user_id))

  <div class="callout callout-warning">
    <h4>ILSM Questions Approved By :{{$ilsm_assessment->ilsmQuestionApprovalUser->name}}</h4>

    <p><strong>Start Date : </strong>{{$ilsm_assessment->start_date->toFormattedDateString()}} to <strong>Approx End Date : </strong>{{$ilsm_assessment->end_date->toFormattedDateString()}}</p>
    @if($ilsm_assessment->ilsm_assessment_status_id == 5)<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ilsm-enddate-modal"><span class="glyphicon glyphicon-pencil"></span> Adjust End Date</button>@endif
  </div>

  @endif



  @if($ilsm_assessment->checklists->isNotEmpty())
        <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">ILSM Checklists ({{$ilsm_assessment->checklists->count()}})</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
          <div class="table-responsive">
            <table class="table no-margin">
              <thead>
              <tr>
                <th>ILSM</th>
                <th>Date</th>
                <th>Frequency</th>
                <th>Shift</th>
                <th>User</th>
                <th>Completed</th>
                <th>Compliant</th>
                <th>Checklist</th>
              </tr>
              </thead>
              <tbody>
                @foreach($ilsm_assessment->checklists->sortBy('date') as $checklist)
                <tr>
                  <td>{{$checklist->ilsm->label}}</td>
                  <td>{{$checklist->date->toFormattedDateString()}}</td>
                  <td>{{$checklist->ilsm->frequency}}</td>
                  <td>@if(!empty($checklist->shift_id)){{$checklist->shift->name}}@else N/A @endif</td>
                  <td>@if(!empty($checklist->user_id)){{$checklist->user->name}}@else N/A @endif</td>
                  <td>@if($checklist->is_answered) Yes @else No @endif</td>
                  <td>@if($checklist->is_compliant) Yes @else No @endif</td>
                  @if($checklist->is_answered)
                      <td>
                        {!! link_to('#','Answers',['class' => 'btn-xs btn-link answers','data-checklist-questions' => json_encode($checklist->ilsm->ilsmChecklistQuestions),'data-checklist-answers' => json_encode($checklist->answers),'data-attachment-required' => $checklist->ilsm->attachment_required,'data-checklist-id' => $checklist->id,'data-attachments' => json_encode($checklist->attachments)]) !!}
                        {!! link_to('#','Re-Attempt',['class' => 'btn-xs btn-link checklist-btn','data-checklist-questions' => json_encode($checklist->ilsm->ilsmChecklistQuestions),'data-attachment-required' => $checklist->ilsm->attachment_required,'data-checklist-id' => $checklist->id]) !!}
                      </td>
                  @else
                      <td>{!! link_to('#','Checklist',['class' => 'btn-xs btn-info checklist-btn','data-checklist-questions' => json_encode($checklist->ilsm->ilsmChecklistQuestions),'data-attachment-required' => $checklist->ilsm->attachment_required,'data-checklist-id' => $checklist->id]) !!}</td>
                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix" style="">
        </div>
        <!-- /.box-footer -->
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

        <!-- ILSM Question Confirmation Modal -->
    <div class="modal fade" id="ilsm-question-approve-modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ILSM Question Approval</h4>
          </div>
          <div class="modal-body">
            <form action="/equipment/ilsm-assessment/ilsm-question-approve" method="post">
                <div class="form-group">
                    <label for="">Mark these question answers as approved and pick an approx end date for checklist completion.</label>
                    {!! Form::text('end_date', $value = '', ['class' => 'form-control date','id' => 'end_date','placeholder' => 'Select Approx. End Date']) !!}
                </div>
              
              {!! Form::hidden('ilsm_assessment_status_id', '5',['id' => 'ilsm_assessment_status_id']) !!}
              {!! Form::hidden('start_date', date('Y-m-d'),['id' => 'start_date']) !!}
              {!! Form::hidden('user_id', Auth::user()->id,['id' => 'user_id']) !!}
              {!! Form::hidden('ilsm_assessment_id', $ilsm_assessment->id,['id' => 'ilsm_assessment_id']) !!}
              {!! Form::hidden('ilsm_approve_user_id', Auth::user()->id,['id' => 'ilsm_approve_user_id']) !!}


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

    <!-- ILSM Sign Off Modal -->
    <div class="modal fade" id="ilsm-signoff-modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ILSM Sign Off</h4>
          </div>
          <div class="modal-body">
            <form action="/equipment/ilsm-assessment/ilsm-sign-off" method="post">
                <div class="form-group">
                    <label for="">Mark this ILSM Assessment as complete and compliant.</label>
                </div>
              
              {!! Form::hidden('ilsm_assessment_status_id', '7',['id' => 'ilsm_assessment_status_id']) !!}
              {!! Form::hidden('ilsm_sign_off_user_id', Auth::user()->id,['id' => 'ilsm_sign_off_user_id']) !!}
              {!! Form::hidden('ilsm_assessment_id', $ilsm_assessment->id,['id' => 'ilsm_assessment_id']) !!}


              <button type="submit" class="btn btn-success">Confirm</button>
              {!! csrf_field() !!}
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


            <!-- ILSM Checklist Modal -->
    <div class="modal fade" id="ilsm-checklist-modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ILSM Checklist</h4>
          </div>
          <div class="modal-body">
            <form action="/equipment/ilsm-assessment/ilsm-checklist" method="post">
                <div id="form-questions">
                </div>
              
              {!! Form::hidden('ilsm_checklist_id', '',['id' => 'ilsm_checklist_id']) !!}
              {!! Form::hidden('answers[attachment]', '',['id' => 'ilsm_checklist_attachment']) !!}
              {!! Form::hidden('ilsm_assessment_id', $ilsm_assessment->id,['id' => 'ilsm_assessment_id']) !!}
              {!! Form::hidden('user_id', Auth::user()->id,['id' => 'user_id']) !!}

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

      <!-- ILSM answer Modal -->
    <div class="modal fade" id="ilsm-answer-modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ILSM Checklist Answers</h4>
          </div>
          <div class="modal-body">
                <div id="form-answers">
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Adjust end date Modal -->
    <div class="modal fade" id="ilsm-enddate-modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ILSM Checklist</h4>
          </div>
          <div class="modal-body">
            <form action="/equipment/ilsm-assessment/ilsm-adjust-enddate" method="post">
                <div class="form-group">
                    <label for="">Adjust end date for the ILSM Assessment</label>
                    {!! Form::text('end_date', $value = '', ['class' => 'form-control date','id' => 'end_date','placeholder' => 'Select Approx. End Date']) !!}
                </div>
              
              {!! Form::hidden('ilsm_assessment_id', $ilsm_assessment->id,['id' => 'ilsm_assessment_id']) !!}
              {!! Form::hidden('user_id', Auth::user()->id,['id' => 'user_id']) !!}


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
  var s3_url = '{{env("S3_URL")}}';

  $("#ilsm-question-approve-modal .date").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "M j, Y",
  });

  @if($ilsm_assessment->ilsm_assessment_status_id == 5)

    $("#ilsm-enddate-modal .date").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "M j, Y",
        minDate: "{{$ilsm_assessment->start_date->format('Y-m-d')}}"
  });

  @endif


  $('.checklist-btn').click(function(){

    var questions = JSON.parse($(this).attr('data-checklist-questions'));

    $('#ilsm-checklist-modal #form-questions').html('');
    $('#ilsm-checklist-modal #ilsm_checklist_id').val($(this).attr('data-checklist-id'));

    var html = '';

    $.each(questions, function(key, value) {
      html += `<div class="form-group">
                    <label for="">${value.question}</label>
                    <select class="form-control" id="checklist-question-${value.id}" name="answers[${value.id}][answer]">
                      <option>Please Select</option>
                      <option value="yes">Yes</option>
                      <option value="no">No</option>
                      <option value="n/a">N/A</option>
                    </select>
                </div>
                <div class="form-group">
                  <textarea class="form-control" rows="3" placeholder="Comment" id="checklist-question-comment-${value.id}" name="answers[${value.id}][comment] cols="50"></textarea>
                </div>`;
    });

    if($(this).attr('data-attachment-required') == '1')
    {
        var directory = 'ilsm/checklist/'+$(this).attr('data-checklist-id')+'/attachment';
        html += '<label for="">Attachment is Required</label><div id="dropzone_'+$(this).attr('data-checklist-id')+'" class="dropzone"></div>';
        $('#ilsm_checklist_attachment').val(directory);
    }

    $('#ilsm-checklist-modal #form-questions').append(html);
    $('#ilsm-checklist-modal').modal('show');

    if($(this).attr('data-attachment-required') == '1')
    {
        $('#dropzone_'+$(this).attr('data-checklist-id')).dropzone({ 
          url: "/dropzone/upload",
          init: function() {
                this.on('sending', function(file, xhr, formData){
                    formData.append('_token', $('meta[name=\"csrf-token\"]').attr('content'));
                    formData.append('folder', directory);
                });
          }
        });

    }
  });

  $('.answers').click(function(){

    var questions = JSON.parse($(this).attr('data-checklist-questions'));
    var answers = JSON.parse($(this).attr('data-checklist-answers'));

    $('#ilsm-answer-modal #form-answers').html('');

    var html = '';

    $.each(questions, function(key, value) {
      html += `<div class="form-group">
                    <label for="">${value.question}</label>
                    <select class="form-control" id="checklist-question-${value.id}" name="answers[${value.id}][answer]">
                      <option>Please Select</option>
                      <option value="yes">Yes</option>
                      <option value="no">No</option>
                      <option value="n/a">N/A</option>
                    </select>
                </div>
                <div class="form-group">
                  <textarea class="form-control" rows="3" placeholder="Comment" id="checklist-question-comment-${value.id}" name="answers[${value.id}][comment] cols="50"></textarea>
                </div>`;
    });

    $('#ilsm-answer-modal #form-answers').append(html);

    var attachment_html = '';

    if($(this).attr('data-attachment-required') == 1)
    {
        var attachment_list = '';
        var attachments = JSON.parse($(this).attr('data-attachments'));
        $.each(attachments, function(key, value) {
          attachment_list += `<a href="${value}" target="_blank" class="list-group-item">${key}</a>`;
        });

        attachment_html = `<div class="list-group">
          <a href="#" class="list-group-item active">Attachments</a>
          ${attachment_list}
        </div>`;
    }

    $('#ilsm-answer-modal #form-answers').append(attachment_html);



    $.each(answers, function(key, value) {
      $('#ilsm-answer-modal #checklist-question-'+key).val(value.answer);
      $('#ilsm-answer-modal #checklist-question-'+key).prop('disabled',true);
      $('#ilsm-answer-modal #checklist-question-comment-'+key).val(value.comment);
      $('#ilsm-answer-modal #checklist-question-comment-'+key).prop('disabled',true);
    });

    $('#ilsm-answer-modal').modal('show');

  });

  </script>
@endsection
