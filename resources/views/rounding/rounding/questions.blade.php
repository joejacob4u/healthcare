@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Rounding Evaluation Questions for '.$rounding->date->toDayDateTimeString())
@section('page_description','Manage roundings here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')


<ol class="breadcrumb">
    <li><a href="{{url('roundings')}}">Roundings</a></li>
    <li>Rounding Questions</li>
</ol>

{!! Form::open(['url' => 'rounding/'.$rounding->id.'/questions', 'class' => 'form-horizontal']) !!}

    <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
            {!! Form::submit('Submit Answers', ['class' => 'btn btn-success pull-right'] ) !!}
        </div>
    </div>


@foreach($rounding->config->checklistType->categories as $category)
    
    <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title"><strong>{{$category->name}}</strong></h3>
          </div>
          <div class="box-body">
            @foreach($category->questions as $question)
                <div class="form-group col-sm-10">
                    {!! Form::label('question_'.$question->id, '( QuesId '.$question->id.') '.$question->question, ['class' => '']) !!}
                        {!! Form::select('answers['.$question->id.'][answer]', ['' => 'Please Select'] + $question->answers['answers'], (!empty($rounding->answers)) ? $rounding->answers[$question->id]['answer'] : Request::old('answers['.$question->id.'][answer]'), ['class' => 'form-control selectpicker answer','id' => 'question_'.$question->id,'data-negative' => $question->answers['negative'],'data-question-id' => $question->id]) !!}
                        {!! Form::hidden('answers['.$question->id.'][negative]', $question->answers['negative'],['id' => '']) !!}
                </div>
                
                <div class="form-group col-sm-12">
                    {!! Form::label('question_'.$question->id.'additional', 'Additional Details', ['class' => '','id' => 'question_'.$question->id.'additional']) !!}
                    <div class="col-lg-4">
                        {!! Form::textarea('answers['.$question->id.'][comment]', (!empty($rounding->answers)) ? $rounding->answers[$question->id]['comment'] : Request::old('answers['.$question->id.'][comment]'), ['class' => 'form-control', 'placeholder' => 'Comment','rows' => 3]) !!}
                    </div>
                    <div class="col-lg-6">
                        {!! HTML::dropzone('answers['.$question->id.'][attachment]','rounding/questions/'.$question->id.'/attachments','true','true') !!}
                    </div>

                </div>

            @endforeach
          </div>
    </div>
@endforeach

    <!-- Submit Button -->
    <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
            {!! Form::submit('Submit Answers', ['class' => 'btn btn-success pull-right'] ) !!}
        </div>
    </div>


{!! Form::close()  !!}

<script>

$('.answer').change(function(){
    if($(this).val() == $(this).attr('data-negative'))
    {
        $('#question_'+$(this).attr('data-question-id')+'additional').html('Please fill out comment and upload attachment (Required)');
        $('#question_'+$(this).attr('data-question-id')+'additional').css('color', 'red');
    }
    else
    {
        $('#question_'+$(this).attr('data-question-id')+'additional').html('Additional Details (Optional)');
        $('#question_'+$(this).attr('data-question-id')+'additional').css('color', 'black');

    }
});

</script>

@endsection
