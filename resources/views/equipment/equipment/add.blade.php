@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add Equipment')
@section('page_description','Add equipments here')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add Equipment</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'equipment', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'Equipment Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', Request::old('name'), ['class' => 'form-control', 'placeholder' => 'Equipment Name']) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('description', 'Equipment Description:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('description', Request::old('description'), ['class' => 'form-control', 'placeholder' => 'Equipment Description (optional)']) !!}
                  </div>
              </div>

             <div class="form-group">
                  {!! Form::label('equipment_pics_path', 'Equipment Pics:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! HTML::dropzone('equipment_pics_path','equipments/'.Auth::user()->healthsystem_id.'/'.strtotime('now'),'false','true') !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('building', 'Building:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('building_name', session('building_name'), ['class' => 'form-control', 'placeholder' => 'Building','disabled' => true]) !!}
                  </div>
              </div>
            
            {!! Form::hidden('building_id', session('building_id')); !!}

            <div class="form-group">
                {!! Form::label('equipment_category_id', 'Equipment Category:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('equipment_category_id', $categories, '', ['class' => 'form-control','id' => 'equipment_category_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('equipment_asset_category_id', 'Equipment Asset Category Id:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('equipment_asset_category_id', [], '', ['class' => 'form-control','id' => 'equipment_asset_category_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('equipment_maintenance_requirement_id', 'Maintenance Requirement Frequency:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('equipment_maintenance_requirement_id', $maintenance_requirements, '', ['class' => 'form-control selectpicker','id' => 'equipment_maintenance_requirement_id','data-live-search' => "true"]); !!}
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('maintenance_redundancy_id', 'Redundancy:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('maintenance_redundancy_id', $redundancies, '', ['class' => 'form-control selectpicker','id' => 'maintenance_redundancy_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('biomed_mission_criticality_id', 'Mission Criticality:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('biomed_mission_criticality_id', $mission_criticalities, '', ['class' => 'form-control selectpicker','id' => 'biomed_mission_criticality_idd','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('equipment_incident_history_id', 'Incident Histories:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('equipment_incident_history_id', $incident_histories, '', ['class' => 'form-control selectpicker','id' => 'equipment_incident_history_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                  {!! Form::label('baseline_date', 'Baseline date:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('baseline_date', Request::old('baseline_date'), ['class' => 'form-control','id' => 'baseline_date']) !!}
                  </div>
            </div>

            <div class="form-group">
                  {!! Form::label('preventive_maintenance_procedure', 'Preventive Maintenance Procedure:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('preventive_maintenance_procedure', Request::old('preventive_maintenance_procedure'), ['class' => 'form-control','id' => 'preventive_maintenance_procedure']) !!}
                  </div>
            </div>

            <div class="form-group">
                  {!! Form::label('preventive_maintenance_procedure_uploade_path', 'Preventive Maintenance Procedure Files:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! HTML::dropzone('preventive_maintenance_procedure_uploade_path','equipments/preventive_maintenance_procedure/'.Auth::user()->healthsystem_id.'/'.strtotime('now'),'false','true') !!}
                  </div>
              </div>


              <div class="form-group">
                  {!! Form::label('manufacturer', 'Manufacturer:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('manufacturer', Request::old('manufacturer'), ['class' => 'form-control']) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('model_number', 'Model Number:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('model_number', Request::old('model_number'), ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('serial_number', 'Serial Number:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('serial_number', Request::old('serial_number'), ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('manufacturer_date', 'Installation Date:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('manufacturer_date', Request::old('manufacturer_date'), ['class' => 'form-control','id' => 'manufacturer_date']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('estimated_replacement_cost', 'Estimated Replacement Cost:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('estimated_replacement_cost', Request::old('estimated_replacement_cost'), ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('estimated_deferred_maintenance_cost', 'Estimated Deferred Maintenance Cost per Year:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('estimated_deferred_maintenance_cost', Request::old('estimated_deferred_maintenance_cost'), ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('identification_number', 'Equipment Inventory Identification:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('identification_number', Request::old('identification_number'), ['class' => 'form-control']) !!}
                  </div>
              </div>

            <div class="form-group">
                {!! Form::label('department_id', 'Department:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('department_id', $departments, '', ['class' => 'form-control selectpicker','id' => 'department_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('room_id', 'Room:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('room_id', [], '', ['class' => 'form-control','id' => 'room_id','data-live-search' => "true"]); !!}
                </div>
            </div>




                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('equipment','Cancel', ['class' => 'btn btn-warning'] ) !!}
                        {!! Form::submit('Add Equipment', ['class' => 'btn btn-success pull-right'] ) !!}
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

    $("#manufacturer_date,#baseline_date").flatpickr({
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






</script>


@endsection
