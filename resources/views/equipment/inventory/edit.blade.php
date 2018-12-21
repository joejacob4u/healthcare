@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add Inventory')
@section('page_description','Add inventories here')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="{{url('equipment')}}">Equipment</a></li>
    <li><a href="{{url('equipment/'.$baseline_date->id.'/baseline-dates')}}">{{$baseline_date->date->toFormattedDateString()}}</a></li>
    <li><a href="{{url('equipment/'.$baseline_date->equipment->id.'/baseline-date/'.$baseline_date->id.'/inventory')}}">Inventory</a></li>
    <li>Edit Inventory</li>
</ol>


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add Inventory</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'equipment/'.$inventory->baselineDate->equipment->id.'/baseline-date/'.$baseline_date->id.'/inventory/edit/'.$inventory->id, 'class' => 'form-horizontal']) !!}

            <div class="form-group">
                  {!! Form::label('name', 'Name:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $inventory->name, ['class' => 'form-control']) !!}
                  </div>
              </div>

             <div class="form-group">
                  {!! Form::label('serial_number', 'Serial Number:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('serial_number', $inventory->serial_number, ['class' => 'form-control']) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('identification_number', 'Equipment Inventory Identification:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('identification_number', $inventory->identification_number, ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('warranty_period', 'Warranty Period:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::number('warranty_period', $inventory->warranty_period, ['class' => 'form-control','id' => 'warranty_period']) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('warranty_start_date', 'Warranty Start Date:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('warranty_start_date', $inventory->warranty_start_date, ['class' => 'form-control','id' => 'warranty_start_date']) !!}
                  </div>
                </div>

                <div class="form-group">
                {!! Form::label('maintenance_redundancy_id', 'Redundancy:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('maintenance_redundancy_id', $redundancies, $inventory->maintenance_redundancy_id, ['class' => 'form-control selectpicker','id' => 'maintenance_redundancy_id','data-live-search' => "true"]); !!}
                </div>
                </div>

            <div class="form-group">
                {!! Form::label('biomed_mission_criticality_id', 'Mission Criticality:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('biomed_mission_criticality_id', $mission_criticalities, $inventory->biomed_mission_criticality_id, ['class' => 'form-control selectpicker','id' => 'biomed_mission_criticality_idd','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('equipment_incident_history_id', 'Incident Histories:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('equipment_incident_history_id', $incident_histories, $inventory->equipment_incident_history_id, ['class' => 'form-control selectpicker','id' => 'equipment_incident_history_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                  {!! Form::label('installation_date', 'Installation Date:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('installation_date', $inventory->installation_date, ['class' => 'form-control','id' => 'installation_date']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('estimated_deferred_maintenance_cost', 'Estimated Deferred Maintenance Cost per Year:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('estimated_deferred_maintenance_cost', $inventory->estimated_deferred_maintenance_cost, ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('estimated_replacement_cost', 'Estimated Replacement Cost:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('estimated_replacement_cost', $inventory->estimated_replacement_cost, ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                {!! Form::label('department_id', 'Department:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('department_id', $departments, $inventory->department_id, ['class' => 'form-control selectpicker','id' => 'department_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('room_id', 'Room:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('room_id', $rooms, $inventory->room_id, ['class' => 'form-control','id' => 'room_id','data-live-search' => "true"]); !!}
                </div>
            </div>



                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('equipment/'.$baseline_date->equipment->id.'/baseline-date/'.$baseline_date->id.'/inventory','Cancel', ['class' => 'btn btn-warning'] ) !!}
                        {!! Form::submit('Edit Inventory', ['class' => 'btn btn-success pull-right'] ) !!}
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

    $("#manufacturer_date,#warranty_start_date,#installation_date").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        altFormat: "F j, Y"
    });

    $("#department_id").change(function(){

        if($(this).val() != 0)
        {
                $.ajax({
                type: 'POST',
                url: '{{ url('system-admin/accreditation/eop/status/fetch/rooms') }}',
                data: { '_token' : '{{ csrf_token() }}', 'department_id': $(this).val() },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    $('#room_id').html('');

                    var html = '<option value="0">Select Room</option>';

                    $.each(data.rooms, function(index, value) {
                        html += '<option value="'+value.id+'">'+value.room_number+'</option>';
                    });

                    $('#room_id').append(html);
                    $('#room_id').selectpicker('refresh');
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


    $("#equipment_category_id").change(function(){

        if($(this).val() != 0)
        {
                $.ajax({
                type: 'POST',
                url: '{{ url('equipment/categories/fetch/asset-categories') }}',
                data: { '_token' : '{{ csrf_token() }}', 'category_id': $(this).val() },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    $('#equipment_asset_category_id').html('');

                    var html = '<option value="0">Select Asset Category</option>';

                    $.each(data.asset_categories, function(index, value) {
                        html += '<option value="'+value.id+'">'+value.name+'</option>';
                    });

                    $('#equipment_asset_category_id').append(html);
                    $('#equipment_asset_category_id').selectpicker('refresh');
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

        $("#equipment_asset_category_id").change(function(){

        if($(this).val() != 0)
        {
                $.ajax({
                type: 'POST',
                url: '{{ url('equipment/categories/fetch/asset-category-details') }}',
                data: { '_token' : '{{ csrf_token() }}', 'asset_category_id': $(this).val() },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    $('#eop_div').html('<h4>EOP Info</h4>');

                    var html = '';

                    $('#preventive_maintenance_procedure').val(data.asset_category.pm_procedure);

                    $.each(data.asset_category.eops, function(index, value) {
                        html +=  `<a href="#" class="list-group-item  list-group-item-info active">
                            <h4>${value.standard_label.label} - EOP : ${value.name}</h4>
                            <p>${value.text}</p>
                        </a>`;
                    });

                    $('#eop_div').append(html);
                    $('#eop_div').show();
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



      $("#is_warranty_available").change(function(){
          
          if($(this).val() == 1){
              $('#warranty_div').show();
          }
          else{
             $('#warranty_div').hide(); 
          }

      });






</script>


@endsection
