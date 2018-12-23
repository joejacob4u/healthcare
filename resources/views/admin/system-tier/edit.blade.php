@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in System Tier</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/system-tier/edit/'.$system_tier->id, 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $system_tier->name, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                  </div>
              </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                <h3 class="box-title">Add Questionnaire</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-primary btn-sm" onclick="addQuestion()" type="button"><span class="glyphicon glyphicon-plus"></span> Add Question</button>
                </div>
                </div>

                <div class="box-body" id="question-box">
                    @foreach($system_tier->workOrderQuestionnaires as $work_order_questionnaire)
                        <div class="row" id="question_{{$work_order_questionnaire->id}}">
                        <div class="col-xs-10">
                            <input type="text" class="form-control input-sm" name="questions[]" value="{{$work_order_questionnaire->question}}" id="question_{{$work_order_questionnaire->id}}" placeholder="Question">
                        </div>
                        <div class="col-xs-1">
                            <button class="btn btn-danger btn-xs" type="button" onclick="deleteQuestion({{$work_order_questionnaire->id}})"><span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="box-footer">
                </div>
            </div>


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! Form::button('Cancel', ['class' => 'btn btn-warning','href' => 'admin/system-tiers'] ) !!}
                        {!! Form::submit('Edit System Tier', ['class' => 'btn btn-success pull-right'] ) !!}
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

    var question_count = {{ $system_tier->workOrderQuestionnaires->max('id') }};

    function addQuestion()
    {
        question_count++;

        var html = `<div class="row" id="question_${question_count}">
                        <div class="col-xs-10">
                            <input type="text" class="form-control input-sm" name="questions[]" id="question_${question_count}" placeholder="Question">
                        </div>
                        <div class="col-xs-1">
                            <button class="btn btn-danger btn-xs" type="button" onclick="deleteQuestion(${question_count})"><span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </div>`;

        $('#question-box').append(html);

    }

    function deleteQuestion(id)
    {
        $('#question_'+id).remove();
    }


</script>

@endsection
