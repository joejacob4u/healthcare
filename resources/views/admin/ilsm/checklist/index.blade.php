@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','ILSMS')
@section('page_description','Manage ilsms checklists for '.$ilsm->label)

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="/admin/ilsms">ILSMs</a></li>
    <li class="active">Checklist Questions</li>
</ol>


    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add ILSM Checklist Question for {{$ilsm->label}}</h3>
        </div>
        <div class="box-body">
            <form class="form" role="form" method="POST" action="{{url('admin/ilsm/'.$ilsm->id.'/checklist-questions')}}">
                <div class="form-group">
                    <label for="question">ILSM Checklkist Question</label>
                    <input type="text" class="form-control" name="question" id="question" placeholder="Enter question">
                    <p class="help-block">The answers will be <i>Yes</i>, <i>No</i>, <i>N/A</i> and free input</p>
                </div>
                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
        <!-- /.box-body -->
      </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Checklist Questions for {{$ilsm->label}}</h3>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Qustion</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($ilsm->ilsmChecklistQuestions as $question)
                    <tr id="tr-{{$question->id}}">
                        <td>{{$question->question}}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteIlsmChecklistQuestion('.$question->id.')']) !!}</td>
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



    <script>

      function deleteIlsmChecklistQuestion(ilsm_checklist_question_id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/ilsm/checklist-questions/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'ilsm_checklist_question_id': ilsm_checklist_question_id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                      if(data.status == 'success')
                      {
                          $('#tr-'+ilsm_checklist_question_id).remove();
                      }
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
