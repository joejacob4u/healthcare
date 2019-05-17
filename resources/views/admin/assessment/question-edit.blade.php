@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Edit Assessment Category Question')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="/admin/assessment/categories/{{$category->id}}/questions"> {{$category->name}} </a></li>
    <li class="active">Edit Question</li>
</ol>



    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Assessment Question for {{$category->name}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/assessment/categories/'.$category->id.'/questions/'.$question->id.'/edit', 'class' => '']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('question', 'Question:', ['class' => 'control-label']) !!}
                  {!! Form::text('question', $question->question, ['class' => 'form-control', 'placeholder' => 'Enter question']) !!}
              </div>

                <div class="form-group">
                <label class="checkbox-inline"><input type="checkbox" name="is_finding" value="1" id="finding-checkbox" @if($question->system_tier_id == 0) checked @endif>Negative Answer triggers an Action Plan Finding.</label>
              </div>

                <div id="work-order-div" @if($question->system_tier_id == 0) style="display:none" @else style="display:block" @endif>

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

                </div>

                <div id="eop-div" @if($question->system_tier_id == 0) style="display:block" @else style="display:none" @endif>

                    <div class="form-group">
                        {!! Form::label('eops', 'EOP:', ['class' => 'col-lg-2 control-label']) !!}
                        {!! Form::select('eops', $eops->prepend('Please select',0), $question->eops, ['class' => 'form-control selectpicker','id' => 'eop_id','data-live-search' => 'true','data-size' => 'false']) !!}
                    </div>

                </div>




                    <div class="box box-info">
                        <div class="box-header">
                        <h3 class="box-title">Answers</h3>
                            <div class="box-tools pull-right">
                                <button id="add-btn" type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span> Answer</button>
                            </div>
                        </div>
                        <div id="answer-box" class="box-body">
                            @foreach($question->answers['answers'] as $key => $answer)
                                @if($key !== 'negative')
                                    <div class="input-group" id="answer-option-{{$key}}">
                                        <div class="input-group-btn">
                                            <button type="button" class="remove-answer btn btn-danger" onclick="removeAnswer({{$key}})">Remove</button>
                                        </div>
                                        <!-- /btn-group -->
                                        <input name="answers[answers][]" type="text" value="{{$answer}}" class="form-control">
                                    </div>
                                    <div id="answer-negative-{{$key}}"><label><input type="checkbox" name="answers[negative]" value="{{$key}}" @if($question->answers['negative'] == $key) checked @endif>Is Negative ?</label></div>
                                @endif
                            @endforeach
                        </div>
                        <!-- /.box-body -->
                    </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! Form::submit('Update Assessment Question', ['class' => 'btn btn-success pull-right'] ) !!}
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

        var answer_count = {{max(array_keys($question->answers['answers']))}};

    $('#add-btn').click(function(){
        
        var answer_field = `<div class="input-group" id="answer-option-${answer_count}">
                                    <div class="input-group-btn">
                                        <button type="button" class="remove-answer btn btn-danger" onclick="removeAnswer(${answer_count})">Remove</button>
                                    </div>
                                    <!-- /btn-group -->
                                    <input name="answers[answers][${answer_count}]" type="text" class="form-control">
                            </div>
                            <div id="answer-negative-${answer_count}"><label><input type="checkbox" name="answers[negative]" value="${answer_count}">Is Negative ?</label></div>`;

        $('#answer-box').append(answer_field);
        answer_count++;
        
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
           url: '{{ url('admin/assessment/categories/'.$category->id.'/questions/fetch-trades') }}',
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
           url: '{{ url('admin/assessment/categories/'.$category->id.'/questions/fetch-problems') }}',
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

    $('#finding-checkbox').change(function(){
      
      if($(this).prop('checked'))
      {
          $('#system_tier_id').selectpicker('val',0);
          $('#work_order_trade_id').val(0);
          $('#work_order_problem_id').val(0);
          $('#work-order-div').hide();
          $('#eop-div').show();
      }
      else
      {
        $('#work-order-div').show();
        $('#eop_id').selectpicker('render');
        $('#eop-div').hide();
      }
   });




    </script>

@endsection

