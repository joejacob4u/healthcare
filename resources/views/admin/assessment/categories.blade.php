@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Assessment Categories for Checklist Type '.$checklist_type->name)
@section('page_description','Manage Assessment categories here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="/admin/assessment/{{$checklist_type->id}}/checklist-types"> Checklist Types </a></li>
    <li class="active">{{$checklist_type->name}} Categories</li>
</ol>


      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Add Assessment Category</h3>
          </div>
          <div class="box-body">
              <form class="form" role="form" method="POST" action="{{url('admin/assessment/checklist-type/'.$checklist_type->id.'/categories')}}">
                <div class="form-group">
                      <label for="name">Category</label>
                      {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'name']) !!}
                  </div>
                  <div class="form-group">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success">Add</button>
                  </div>
              </form>
          </div>
          <!-- /.box-body -->
        </div>


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Assessment Categories</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Questions</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Category</th>
                        <th>Questions</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($checklist_type->categories as $category)
                    <tr id="tr-{{$category->id}}">
                      <td>{{$category->name}}</td>
                      <td>{!! link_to('admin/assessment/categories/'.$category->id.'/questions','Questions',['class' => 'btn-xs btn-primary']) !!}</td>
                      <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteAssessmentCategory('.$category->id.')']) !!}</td>
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
      function deleteAssessmentCategory(category_id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/assessment/categories/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'id': category_id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                      if(data.status == 'success')
                      {
                          $('#tr-'+category_id).remove();
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
