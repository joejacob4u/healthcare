@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Project Ranking Questions')
@section('page_description','Manage questions and answers here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

      <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add Question</h3>
      </div>
      <div class="box-body">
          <form class="form-horizontal" action="{{url('project/ranking-questions/add')}}" method="post">
          <div class="form-group">
            <label class="control-label col-sm-2" for="question">Question:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="question" name="question" placeholder="Add question">
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
        <h3 class="box-title">Existing Questions</h3>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answers</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Question</th>
                        <th>Answers</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($questions as $question)
                    <tr id="tr-{{$question->id}}">
                        <td class="question">{{$question->question}}</td>
                        <td>{!! link_to('project/ranking-questions/'.$question->id.'/answers','Answers',['class' => 'btn-xs btn-primary']) !!}</td>
                        <td>{!! link_to('#','Edit',['class' => 'btn-xs btn-warning','onclick' => 'editQuestionModal('.$question->id.')']) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteQuestion('.$question->id.')']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
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
    <div id="questionModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Question</h4>
          </div>
          <div class="modal-body">
            <label class="control-label col-sm-2" for="question">Question:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="question" name="question" placeholder="Edit question">
              <input type="hidden"  name="question_id" id="question_id" value="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" onclick="editQuestion()">Edit</button>
          </div>
        </div>

      </div>
    </div>

    <!-- End question Modal-->


    <script>
      function showAccreditationRequirements(id)
      {
        $.ajax({
          type: 'POST',
          url: '{{ url('admin/accreditation/info') }}',
          data: { '_token' : '{{ csrf_token() }}', 'id': id },
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            $('#requirementsModal ul').html('');

            var html = '';

            $.each(data, function(index, value) {
                html += '<li><a href="accreditation-requirements/edit/'+value.id+'">'+value.name+'</a></li>';
            });

            $('#requirementsModal ul').append(html);

            $('#requirementsModal').modal('show');
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

      function editQuestionModal(id)
      {
        $('#questionModal #question_id').val(id);
        $('#questionModal').modal('show');
          
      }

      function editQuestion()
      {
        var question = $('#questionModal #question').val();
        var question_id = $('#questionModal #question_id').val();

        $.ajax({
          type: 'POST',
          url: '{{ url('project/ranking-questions/edit') }}',
          data: { '_token' : '{{ csrf_token() }}', 'question_id': question_id, 'question': question },
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
              $('#questionModal').modal('hide');
              $('#tr-'+data.id+' .question').html(data.question);
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

      function deleteQuestion(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('project/ranking-questions/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'question_id': id},
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
