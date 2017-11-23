@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Project Ranking Answers')
@section('page_description','Manage questions and answers here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

      <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add Answer for Question : {{$question->question}}</h3>
      </div>
      <div class="box-body">
          <form class="form-horizontal" action="{{url('project/ranking-questions/answers/add')}}" method="post">
          <div class="form-group">
            <label class="control-label col-sm-2" for="question">Answer:</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="answer" name="answer" placeholder="Add answer">
              <input type="hidden" class="form-control" id="question_id" name="question_id" value="{{$question->id}}">
            </div>
            <div class="col-sm-2">
              <input type="text" class="form-control" id="score" name="score" placeholder="Score">
            </div>
            <div class="col-sm-2">
              <button type="submit" class="btn btn-success">Add</button>
            </div>
          </div>
          {{ csrf_field() }}
        </form>
      </div>
      </div>


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Answers</h3>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Answer</th>
                        <th>Score</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Answer</th>
                        <th>Score</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($answers as $answer)
                    <tr id="tr-{{$answer->id}}">
                        <td class="answer">{{$answer->answer}}</td>
                        <td class="score">{{$answer->score}}</td>
                        <td>{!! link_to('#','Edit',['class' => 'btn-xs btn-warning','onclick' => 'editAnswerModal('.$answer->id.')']) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteAnswer('.$answer->id.')']) !!}</td>
                    </tr>
                        
                    @endforeach
                </tbody>
            </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <a href="{{url('project/ranking-questions')}}" class="btn btn-warning">Go Back</a>
      </div>
      <!-- /.box-footer-->
    </div>

    <!-- Start Modal-->
    <div id="requirementsModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Accreditation Requirements</h4>
          </div>
          <div class="modal-body">
            <ul></ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <!-- End Modal-->

        <!-- Question Modal-->
    <div id="answerModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Answer</h4>
          </div>
          <div class="modal-body">
            <form role="form">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Answer</label>
                      <input type="text" class="form-control"
                      id="answer" placeholder="Enter answer"/>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Score</label>
                      <input type="text" class="form-control"
                          id="score" placeholder="score"/>
                          <input type="hidden" class="form-control"
                          id="answer_id"/>
                  </div>
                </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" onclick="editAnswer()">Edit</button>
          </div>
        </div>

      </div>
    </div>

    <!-- End question Modal-->


    <script>
      function editAnswerModal(id)
      {
        $('#answerModal #answer_id').val(id);
        $('#answerModal').modal('show');
          
      }

      function editAnswer()
      {
        var answer = $('#answerModal #answer').val();
        var answer_id = $('#answerModal #answer_id').val();
        var score = $('#answerModal #score').val();

        $.ajax({
          type: 'POST',
          url: '{{ url('project/ranking-questions/answers/edit') }}',
          data: { '_token' : '{{ csrf_token() }}', 'answer_id': answer_id, 'answer': answer ,'score': score},
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
              $('#answerModal').modal('hide');
              $('#tr-'+data.id+' .answer').html(data.answer);
              $('#tr-'+data.id+' .score').html(data.score);
          },
          complete:function()
          {
             $('.overlay').remove();
          },
          error:function()
          {
            // failed request; give feedback to user
          }
        });

      }

      function deleteAnswer(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('project/ranking-questions/answers/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'answer_id': id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                        $('#tr-'+data).remove();
                    },
                    complete:function()
                    {
                        $('.overlay').remove();
                    },
                    error:function()
                    {
                        // failed request; give feedback to user
                    }
                });
             } 
          });

      }
    </script>

@endsection
