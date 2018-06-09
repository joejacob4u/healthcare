@extends('layouts.app')

@section('head')
@parent
@endsection
@section('page_title','Edit Department')
@section('page_description','edit department here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit department for {{$department->building->name}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/buildings/'.$department->building->id.'/departments/'.$department->id.'/edit', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <div class="form-group">
                  {!! Form::label('name', 'Department Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $department->name, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                  </div>
              </div>

              <!-- Phone -->
              <div class="form-group">
                  {!! Form::label('business_unit_cost_center', 'Business Unit / Cost Center:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('business_unit_cost_center', $department->business_unit_cost_center, ['class' => 'form-control', 'placeholder' => '']) !!}
                  </div>
              </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('admin/sites/'.$department->building->site->id.'/buildings/'.$department->building->id.'/departments', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Edit Department', ['class' => 'btn btn-success pull-right'] ) !!}
                    </div>
                </div>

            </fieldset>
            {!! Form::hidden('building_id', $department->building->id, ['class' => 'form-control']) !!}
            {!! Form::close()  !!}
               </div>
      <!-- /.box-body -->
      <div class="box-footer">
        {{ link_to('#', $title = 'Delete', $attributes = ['class' => 'btn btn-danger pull-right','onclick' => 'deleteDepartment('.$department->id.')'], $secure = null)}}
      </div>
     


    </div>

    <script>

    function deleteDepartment(department_id)
    {
        bootbox.confirm("Do you really want to delete?", function(result)
        {
          if(result){

            $.ajax({
              type: 'POST',
              url: '{{ asset('admin/departments/delete') }}',
              data: { '_token' : '{{ csrf_token() }}', 'department_id': department_id },
              beforeSend:function()
              {
                $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
              },
              success:function(data)
              {
                  if(data == 'true')
                  {
                    window.location = "{{url('admin/sites/'.$department->building->site->id.'/buildings/'.$department->building->id.'/departments')}}";
                  }
                  else {
                    bootbox.alert("Something went wrong, try again later");
                  }
              },
              error:function()
              {
                // failed request; give feedback to user
              },
              complete: function(data)
              {
                  $('.overlay').remove();
              }
            });
          }
        });
    }


    </script>

@endsection
