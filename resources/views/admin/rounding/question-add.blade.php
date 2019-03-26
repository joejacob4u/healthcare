@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add Rounding Category Question')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="/admin/rounding/categories/{{$category->id}}/questions"> {{$category->name}} </a></li>
    <li class="active">Add Question</li>
</ol>



    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add Rounding Question for {{$category->name}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/rounding/categories/'.$category->id.'/questions', 'class' => '']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('question', 'Question:', ['class' => 'control-label']) !!}
                  {!! Form::text('question', Request::old('question'), ['class' => 'form-control', 'placeholder' => 'Enter question']) !!}
              </div>

                <div class="form-group">
                    {!! Form::label('system_tier_id', 'System Tier:', ['class' => 'col-lg-2 control-label']) !!}
                      {!! Form::select('system_tier_id', $system_tiers->prepend('Please select',0), Request::old('system_tier_id'), ['class' => 'form-control','id' => 'system_tier_id']) !!}
                </div>


                <div class="form-group">
                    {!! Form::label('work_order_trade_id', 'Trade:', ['class' => 'col-lg-2 control-label']) !!}
                      {!! Form::select('work_order_trade_id', [], Request::old('work_order_trade_id'), ['class' => 'form-control','id' => 'work_order_trade_id']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('work_order_problem_id', 'Problem:', ['class' => 'col-lg-2 control-label']) !!}
                      {!! Form::select('work_order_problem_id', [], Request::old('work_order_problem_id'), ['class' => 'form-control','id' => 'work_order_problem_id']) !!}
                </div>

                    <div class="box box-info">
                        <div class="box-header">
                        <h3 class="box-title">Answers</h3>
                            <div class="box-tools pull-right">
                                <button id="add-btn" type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span> Answer</button>
                            </div>
                        </div>
                        <div id="answer-box" class="box-body">
                        </div>
                        <!-- /.box-body -->
                    </div>


                <div class="form-group">
                    {!! Form::label('eops', 'EOP:', ['class' => 'col-lg-2 control-label']) !!}
                     {!! Form::select('eops[]', $eops->prepend('Please select',0), Request::old('eop_id'), ['class' => 'form-control selectpicker','multiple' => true,'id' => 'eop_id','data-live-search' => 'true','data-size' => 'false']) !!}
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! Form::submit('Add Rounding Question', ['class' => 'btn btn-success pull-right'] ) !!}
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
    var answer_count = 0;

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
                $('#work_order_trade_id').selectpicker('refresh');

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
                $('#work_order_problem_id').selectpicker('refresh');

           },
           complete:function(){}
      });

  });




    </script>

@endsection
