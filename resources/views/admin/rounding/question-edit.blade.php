@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Edit Rounding Category Question')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="/admin/rounding/categories/{{$category->id}}/questions"> {{$category->name}} </a></li>
    <li class="active">Edit Question</li>
</ol>



    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add Rounding Question for {{$category->name}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/rounding/categories/'.$category->id.'/questions/'.$question->id.'/edit', 'class' => '']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('question', 'Question:', ['class' => 'control-label']) !!}
                  {!! Form::text('question', $question->question, ['class' => 'form-control', 'placeholder' => 'Enter question']) !!}
              </div>


                <div class="form-group">
                    {!! Form::label('system_tier_id', 'System Tier:', ['class' => 'col-lg-2 control-label']) !!}
                      {!! Form::select('system_tier_id', $system_tiers->prepend('Please select',0), $question->system_tier_id, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('work_order_trade_id', 'Trade:', ['class' => 'col-lg-2 control-label']) !!}
                      {!! Form::select('work_order_trade_id', \App\Equipment\Trade::where('system_tier_id',$question->system_tier_id)->pluck('name','id'), $question->work_order_trade_id, ['class' => 'form-control','id' => 'work_order_trade_id']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('work_order_problem_id', 'Problem:', ['class' => 'col-lg-2 control-label']) !!}
                      {!! Form::select('work_order_problem_id', \App\Equipment\Problem::where('work_order_trade_id',$question->work_order_trade_id)->pluck('name','id'), $question->work_order_problem_id, ['class' => 'form-control','id' => 'work_order_problem_id']) !!}
                </div>



                    <div class="box box-info">
                        <div class="box-header">
                        <h3 class="box-title">Answers</h3>
                            <div class="box-tools pull-right">
                                <button id="add-btn" type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span> Answer</button>
                            </div>
                        </div>
                        <div id="answer-box" class="box-body">
                            @foreach($question->answers['answer'] as $key => $answer)
                                @if($key !== 'negative')
                                    <div class="input-group" id="answer-option-{{$key}}">
                                        <div class="input-group-btn">
                                            <button type="button" class="remove-answer btn btn-danger" onclick="removeAnswer({{$key}})">Remove</button>
                                        </div>
                                        <!-- /btn-group -->
                                        <input name="answers[answer][]" type="text" value="{{$answer}}" class="form-control">
                                    </div>
                                    <div id="answer-negative-{{$key}}"><label><input type="checkbox" name="answers[answer][negative]" value="{{$key}}" @if($question->answers['answer']['negative'] == $key) checked @endif>Is Negative ?</label></div>
                                @endif
                            @endforeach
                        </div>
                        <!-- /.box-body -->
                    </div>


                <div class="form-group">
                    {!! Form::label('eops', 'EOP:', ['class' => 'col-lg-2 control-label']) !!}
                     {!! Form::select('eops[]', $eops->prepend('Please select',0), $question->eops, ['class' => 'form-control selectpicker','multiple' => true,'id' => 'eop_id','data-live-search' => 'true','data-size' => 'false']) !!}
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! Form::submit('Update Rounding Question', ['class' => 'btn btn-success pull-right'] ) !!}
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

        var answer_count = {{max(array_keys($question->answers['answer']))}};

    $('#add-btn').click(function(){

        answer_count++;
        
        var answer_field = `<div class="input-group" id="answer-option-${answer_count}">
                                    <div class="input-group-btn">
                                        <button type="button" class="remove-answer btn btn-danger" onclick="removeAnswer(${answer_count})">Remove</button>
                                    </div>
                                    <!-- /btn-group -->
                                    <input name="answers[answer][]" type="text" class="form-control">
                            </div>
                            <div id="answer-negative-${answer_count}"><label><input type="checkbox" name="answers[answer][negative]" value="${answer_count}">Is Negative ?</label></div>`;

        $('#answer-box').append(answer_field);
        
    });


    function removeAnswer(answer_count)
    {
        $('#answer-option-'+answer_count).remove();
        $('#answer-negative-'+answer_count).remove();
         answer_count--;
    }

    $(document).ready(function(){
      $('[data-toggle="popover"]').popover();
  });

  $('#system_tier_id').change(function(){

      $.ajax({
           type: 'POST',
           url: '{{ url('admin/rounding/categories/'.$category->id.'/questions/fetch-trades') }}',
           data: { '_token' : '{{ csrf_token() }}','system_tier_id' : $(this).val()},
           beforeSend:function(){},
           success:function(data)
           {
                $('#work_order_trade_id').html('');

                var html = '<option value="0">Select Trade</option>';

               $.each(data.trades, function(index, value) {
                   html += '<option value="'+value.id+'">'+value.name+'</option>';
                });

                $('#work_order_trade_id').append(html);
                $('#work_order_trade_id').selectpicker('render');

           },
           complete:function(){}
      });

  });

    $('#work_order_trade_id').change(function(){

      $.ajax({
           type: 'POST',
           url: '{{ url('admin/rounding/categories/'.$category->id.'/questions/fetch-problems') }}',
           data: { '_token' : '{{ csrf_token() }}','work_order_trade_id' : $(this).val()},
           beforeSend:function(){},
           success:function(data)
           {
                $('#work_order_problem_id').html('');

                var html = '<option value="0">Select Problem</option>';

               $.each(data.problems, function(index, value) {
                   html += '<option value="'+value.id+'">'+value.name+'</option>';
                });

                $('#work_order_problem_id').append(html);
                $('#work_order_problem_id').selectpicker('render');

           },
           complete:function(){}
      });

  });



    </script>

@endsection

