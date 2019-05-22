@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Tracer Checklist Types')
@section('page_description','Manage assessment checklist types here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="/admin/tracer/sections">Sections</a></li>
    <li class="active">Tracers for {{$section->name}}</li>
</ol>


      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Add Tracer Checklist Type for {{$section->name}}</h3>
          </div>
          <div class="box-body">
              <form class="form" role="form" method="POST" action="{{url('admin/tracer/'.$section->id.'/checklist-types')}}">
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
        <h3 class="box-title">Tracer Checklist Types</h3>

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
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Checklist Type</th>
                        <th>Accreditations</th>
                        <th>Categories</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($section->checklistTypes as $checklist_type)
                    <tr id="tr-{{$checklist_type->id}}">
                      <td>{{$checklist_type->name}}</td>
                      <td>{{$checklist_type->accreditations->implode('name',',')}}</td>
                      <td>{!! link_to('admin/tracer/checklist-type/'.$checklist_type->id.'/categories','Categories',['class' => 'btn-xs btn-primary']) !!}</td>
                      <td>{!! link_to('#','Edit',['class' => 'btn-xs btn-info edit-checklist','data-checklist-id' => $checklist_type->id,'data-name' => $checklist_type->name,'data-accreditations' => $checklist_type->accreditations->pluck('id')]) !!}</td>
                      <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteTracerChecklistType('.$checklist_type->id.')']) !!}</td>
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

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Checklist</h4>
        </div>
        <div class="modal-body">
              <form class="form" role="form" method="POST" action="{{url('admin/tracer/'.$section->id.'/checklist-types/edit')}}">
                  <div class="form-group">
                      <label for="name">Checklist Type</label>
                      {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'name', 'id' => 'name']) !!}
                  </div>
                  <div class="form-group">
                      <label for="name">Accreditation</label>
                      {!! Form::select('accreditations[]', $accreditations, '', ['class' => 'form-control select-picker','id' => 'edit-accreditations','multiple' => true]); !!}
                  </div>

                  {!! Form::hidden('checklist_type_id', '',['id' => 'checklist_type_id']) !!}

                  <div class="form-group">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success">Update</button>
                  </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


    <script>
      function deleteTracerChecklistType(checklist_type_id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/tracer/checklist-type/delete') }}',
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

      //edit checklist

      $('.edit-checklist').click(function(){


        var checklist_type_id = $(this).attr('data-checklist-id');
        var name = $(this).attr('data-name');
        var accreditations = JSON.parse($(this).attr('data-accreditations'));

        $('#editModal #checklist_type_id').val(checklist_type_id);
        $('#editModal #name').val(name);
        $('#editModal #edit-accreditations').val(accreditations);
        $('#editModal #edit-accreditations').selectpicker('refresh');

        $('#editModal').modal('show');


      })
    </script>

@endsection
