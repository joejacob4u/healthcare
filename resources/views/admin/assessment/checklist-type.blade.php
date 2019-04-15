@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Assessment Checklist Types')
@section('page_description','Manage assessment checklist types here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Add Assessment Checklist Type</h3>
          </div>
          <div class="box-body">
              <form class="form" role="form" method="POST" action="{{url('admin/assessment/checklist-types')}}">
                  <div class="form-group">
                      <label for="name">Checklist Type</label>
                      {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'name']) !!}
                  </div>
                  <div class="form-group">
                      <label for="name">Accreditation</label>
                      {!! Form::select('accreditations[]', $accreditations, '', ['class' => 'form-control selectpicker','id' => 'accreditations','multiple' => true]); !!}
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
        <h3 class="box-title">Rounding Checklist Types</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Checklist Type</th>
                        <th>Accreditations</th>
                        <th>Categories</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Checklist Type</th>
                        <th>Accreditations</th>
                        <th>Categories</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($checklist_types as $checklist_type)
                    <tr id="tr-{{$checklist_type->id}}">
                      <td>{{$checklist_type->name}}</td>
                      <td>{{$checklist_type->accreditations->implode('name',',')}}</td>
                      <td>{!! link_to('admin/assessment/checklist-type/'.$checklist_type->id.'/categories','Categories',['class' => 'btn-xs btn-primary']) !!}</td>
                      <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteAssessmentChecklistType('.$checklist_type->id.')']) !!}</td>
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
      function deleteAssessmentChecklistType(checklist_type_id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/assessment/checklist-type/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'id': checklist_type_id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                      if(data.status == 'success')
                      {
                          $('#tr-'+checklist_type_id).remove();
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
