{!! Form::open(['url' => 'projects/ranking-questions/edit/'.$project->id, 'class' => 'form-horizontal']) !!}

@foreach($ranking_questions as $question)

<div class="form-group">
    {!! Form::label('question_'.$question->id, $question->question, ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('question_'.$question->id, $question->answers->pluck('answer','id'),'', ['placeholder' => 'Select answer','class' => 'form-control']); !!}
    </div>
</div>

@endforeach

<div class="form-group">
<div class="col-lg-10 col-lg-offset-2">
    {{ link_to('projects', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
    {!! Form::submit('Save Ranking Questions', ['class' => 'btn btn-success pull-right'] ) !!}
</div>
</div>
</fieldset>


{!! Form::close()  !!}