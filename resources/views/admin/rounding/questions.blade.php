@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Rounding Category Questions')
@section('page_description','Manage rounding categories here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="/admin/rounding/checklist-type/{{$category->checklist_type_id}}/categories"> Categories </a></li>
    <li class="active">Questions for {{$category->name}}</li>
</ol>


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Rounding Questions for {{$category->name}}</h3>

        <div class="box-tools pull-right">
            <a href="{{url('admin/rounding/categories/'.$category->id.'/questions/create')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add Question</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answers</th>
                        <th>Tier</th>
                        <th>EOP</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Question</th>
                        <th>Answers</th>
                        <th>Tier</th>
                        <th>EOP</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($category->questions as $question)
                    <tr id="tr-{{$question->id}}">
                      <td>{{$question->question}}</td>
                      <td>{!! link_to('#','Answers',['class' => 'btn-xs btn-primary','data-toggle' => "popover", 'title' => "Answers", 'data-trigger' => "click", 'data-content' => implode('<br>',$question->answers['answer']),'data-html' => 'true']) !!}</td>
                      <td>{{$question->systemTier->name}}</td>
                      <td>{!! link_to('#','EOP',['class' => 'btn-xs btn-info','data-toggle' => "popover", 'title' => "EOPs", 'data-trigger' => "click", 'data-content' => (!empty($question->eops)) ? \App\Regulatory\EOP::whereIn('id',$question->eops)->get()->implode('text','<br>') : 'N/A','data-html' => 'true']) !!}</td>
                      <td>{!! link_to('admin/rounding/categories/'.$category->id.'/questions/'.$question->id.'/edit','Edit',['class' => 'btn-xs btn-warning']) !!}</td>
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

    <script>
      function deleteQuestion(question_id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/rounding/categories/'.$category->id.'/questions/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'id': question_id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                      if(data.status == 'success')
                      {
                          $('#tr-'+question_id).remove();
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

          $(document).ready(function(){
              $('[data-toggle="popover"]').popover();
          });

    </script>

@endsection
