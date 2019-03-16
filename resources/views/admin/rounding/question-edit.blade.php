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


                    <div class="box box-info">
                        <div class="box-header">
                        <h3 class="box-title">Answers</h3>
                            <div class="box-tools pull-right">
                                <button id="add-btn" type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span> Answer</button>
                            </div>
                        </div>
                        <div id="answer-box" class="box-body">
                            @foreach($question->answers as $answer)
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="remove-answer btn btn-danger">Remove</button>
                                </div>
                                <!-- /btn-group -->
                                <input name="answers[]" type="text" value="{{$answer}}" class="form-control">
                            </div>
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

    $('#add-btn').click(function(){
        
        var answer_field = `<div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="remove-answer btn btn-danger">Remove</button>
                                </div>
                                <!-- /btn-group -->
                                <input name="answers[]" type="text" class="form-control">
                            </div>`;

        $('#answer-box').append(answer_field);
        
    });

    $(document).on("click",".remove-answer",function() {
        $(this).closest('.input-group').remove();
    });

    $(document).ready(function(){
      $('[data-toggle="popover"]').popover();
  });



    </script>

@endsection
