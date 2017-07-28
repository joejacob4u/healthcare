@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Health Card Organizations Sites')
@section('page_description','edit sites here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit building  for {{$site->name}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/sites/'.$site->id.'/buildings/edit/'.$building->id, 'class' => 'form-horizontal']) !!}

            <fieldset>

              <div class="form-group">
                  {!! Form::label('name', 'Building Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $building->name, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                  </div>
              </div>

              <!-- Phone -->
              <div class="form-group">
                  {!! Form::label('building_id', 'Building Id:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('building_id', $building->building_id, ['class' => 'form-control', 'placeholder' => 'id']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('occupancy_type', 'Occupancy Type:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('occupancy_type', $occupancy_types, $building->occupancy_type, ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('square_ft', 'Square Ft', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('square_ft', $building->square_ft, ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('roof_sq_ft', 'Roof Square Ft', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('roof_sq_ft', $building->roof_sq_ft, ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('ownership', 'Ownership Type:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('ownership', $ownership_types, $building->ownership, ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('ownership_comments', 'Ownership Comments', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('ownership_comments', $building->ownership_comments, ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('sprinkled_pct', 'Sprinkled Percentage', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('sprinkled_pct', $building->sprinkled_pct, ['class' => 'form-control','data-provide' => 'slider','data-slider-min' => '0','data-slider-max' => '100','data-slider-step' => '5','data-slider-value' => $building->sprinkled_pct]) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('beds', 'Beds', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('beds', $building->beds, ['class' => 'form-control']) !!}
                  </div>
              </div>


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('admin/sites/'.$site->id.'/buildings', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        <button type="button" onclick="deleteBuilding('{{$building->id}}')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                        {!! Form::submit('Update Building', ['class' => 'btn btn-success pull-right'] ) !!}
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

    function deleteBuilding(id)
    {
        bootbox.confirm("Do you really want to delete?", function(result)
        {
          if(result){

            $.ajax({
              type: 'POST',
              url: '{{ asset('admin/sites/buildings/delete') }}',
              data: { '_token' : '{{ csrf_token() }}', 'id': id },
              beforeSend:function()
              {
                $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
              },
              success:function(data)
              {
                  if(data == 'true')
                  {
                    window.location = "{{url('admin/sites/'.$site->id.'/buildings')}}";
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
