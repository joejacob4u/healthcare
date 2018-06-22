@extends('layouts.app')

@section('head')
@parent
@endsection
@section('page_title','Edit Room')
@section('page_description','edit room here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit room for {{$room->buildingDepartment->name}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'departments/'.$room->buildingDepartment->id.'/rooms/'.$room->id.'/edit', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <div class="form-group">
                  {!! Form::label('room_number', 'Room Number:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('room_number', $room->room_number, ['class' => 'form-control', 'placeholder' => 'Room Number']) !!}
                  </div>
              </div>

              <!-- Phone -->
              <div class="form-group">
                  {!! Form::label('room_type', 'Room Type:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('room_type', $room->room_type, ['class' => 'form-control', 'placeholder' => 'room type']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('is_clinical', 'Is Clinical', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('is_clinical',['-1' => 'Please Select','1' => 'Yes','0' => 'No'], $room->is_clinical, ['class' => 'form-control selectpicker']) !!}
                  </div>
              </div>


              <div class="form-group">
                  {!! Form::label('square_ft', 'Square Ft:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('square_ft', $room->square_ft, ['class' => 'form-control', 'placeholder' => 'Square Ft']) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('bar_code', 'Bar Code:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('bar_code', $room->bar_code, ['class' => 'form-control', 'placeholder' => 'Bar Code']) !!}
                  </div>
            </div>

            <div class="form-group">
                  {!! Form::label('sprinkled_pct', 'Sprinkled Percentage %:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('sprinkled_pct', $room->sprinkled_pct, ['class' => 'form-control', 'placeholder' => 'Sprinkled %']) !!}
                  </div>
            </div>

            <div class="form-group">
                  {!! Form::label('beds', 'Beds:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('beds', $room->beds, ['class' => 'form-control', 'placeholder' => 'No of beds']) !!}
                  </div>
            </div>

            <div class="form-group">
                  {!! Form::label('unused_space_sq_ft', 'Unused Space Sq Ft:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('unused_space_sq_ft', $room->unused_space_sq_ft, ['class' => 'form-control', 'placeholder' => 'Unused Space Sq Ft']) !!}
                  </div>
            </div>


            <div class="form-group">
                  {!! Form::label('operating_rooms', 'Operating Rooms:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('operating_rooms', $room->operating_rooms, ['class' => 'form-control', 'placeholder' => 'Operating Rooms']) !!}
                  </div>
            </div>


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('buildings/'.$room->buildingDepartment->building->id.'/departments/'.$room->buildingDepartment->id.'/rooms', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Update Room', ['class' => 'btn btn-success pull-right'] ) !!}
                    </div>
                </div>

            </fieldset>
            {!! Form::hidden('building_department_id', $room->buildingDepartment->id) !!}
            {!! Form::close()  !!}
               </div>
      <!-- /.box-body -->
      <div class="box-footer">
        {{ link_to('#', $title = 'Delete', $attributes = ['class' => 'btn btn-danger pull-right','onclick' => 'deleteRoom('.$room->id.')'], $secure = null)}}
      </div>
      


    </div>

    <script>

    function deleteRoom(room_id)
    {
        bootbox.confirm("Do you really want to delete?", function(result)
        {
          if(result){

            $.ajax({
              type: 'POST',
              url: '{{ asset('rooms/delete') }}',
              data: { '_token' : '{{ csrf_token() }}', 'room_id': room_id },
              beforeSend:function()
              {
                $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
              },
              success:function(data)
              {
                  if(data == 'true')
                  {
                    window.location = "{{url('buildings/'.$room->buildingDepartment->building->id.'/departments/'.$room->buildingDepartment->id.'/rooms')}}";
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
