@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Assessment Sections')
@section('page_description','Manage assessment sections here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Add Assessment Section</h3>
          </div>
          <div class="box-body">
              <form class="form" role="form" method="POST" action="{{url('admin/assessment/sections')}}">
                  <div class="form-group">
                      <label for="name">Section</label>
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
        <h3 class="box-title">Assessment Sections</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Section Name</th>
                        <th>Checklist Types</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Section Name</th>
                        <th>Checklist Types</th>
                        <th>Delete</th>

                    </tr>
                </tfoot>
                <tbody>
                  @foreach($sections as $section)
                    <tr id="tr-{{$section->id}}">
                      <td>{{$section->name}}</td>
                      <td>{!! link_to('admin/assessment/'.$section->id.'/checklist-types','Checklist Types',['class' => 'btn-xs btn-info']) !!}</td>
                      <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteAssessmentSection('.$section->id.')']) !!}</td>
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
      function deleteAssessmentSection(section_id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/assessment/sections/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'id': section_id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                      if(data.status == 'success')
                      {
                          $('#tr-'+section_id).remove();
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
