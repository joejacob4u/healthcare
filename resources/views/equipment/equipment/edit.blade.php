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
        {!! Form::open(['url' => 'equipment/edit', 'class' => 'form-horizontal']) !!}

            <fieldset>

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
                {!! Form::select('equipment_category_id', $categories, $equipment->equipment_category_id, ['class' => 'form-control','id' => 'equipment_category_id','data-live-search' => "true"]); !!}
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('equipment_asset_category_id', 'Equipment Asset Category:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('equipment_asset_category_id', App\Equipment\Category::find($equipment->equipment_category_id)->assetCategories->pluck('name','id'), $equipment->equipment_asset_category_id, ['class' => 'form-control','id' => 'equipment_asset_category_id','data-live-search' => "true"]); !!}
                </div>
            </div>


              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'Equipment Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $equipment->name, ['class' => 'form-control', 'placeholder' => 'Equipment Name']) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('description', 'Equipment Description:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('description', $equipment->description, ['class' => 'form-control', 'placeholder' => 'Equipment Description (optional)','rows' => 3]) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('equipment_pics_path', 'Equipment Pics:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! HTML::dropzone('equipment_pics_path',$equipment->equipment_pics_path,'true','true') !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('manufacturer', 'Manufacturer:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('manufacturer', $equipment->manufacturer, ['class' => 'form-control']) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('model_number', 'Model Number:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('model_number', $equipment->model_number, ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('serial_number', 'Serial Number:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('serial_number', $equipment->serial_number, ['class' => 'form-control']) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('preventive_maintenance_procedure', 'Preventive Maintenance Procedure:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('preventive_maintenance_procedure', $equipment->preventive_maintenance_procedure, ['class' => 'form-control','id' => 'preventive_maintenance_procedure']) !!}
                  </div>
            </div>

            <div class="form-group">
                  {!! Form::label('preventive_maintenance_procedure_uploade_path', 'Preventive Maintenance Procedure Files:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! HTML::dropzone('preventive_maintenance_procedure_uploade_path',$equipment->preventive_maintenance_procedure_uploade_path,'true','true') !!}
                  </div>
              </div>


            <div class="form-group">
                {!! Form::label('equipment_maintenance_requirement_id', 'Maintenance Requirement Frequency:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('equipment_maintenance_requirement_id', $maintenance_requirements, $equipment->equipment_maintenance_requirement_id, ['class' => 'form-control selectpicker','id' => 'equipment_maintenance_requirement_id','data-live-search' => "true"]); !!}
                </div>
            </div>




            <div class="form-group">
                {!! Form::label('maintenance_redundancy_id', 'Redundancy:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('maintenance_redundancy_id', $redundancies, $equipment->maintenance_redundancy_id, ['class' => 'form-control','id' => 'maintenance_redundancy_id','data-live-search' => "true"]); !!}
                </div>
            </div>

                        <div class="form-group">
                {!! Form::label('biomed_mission_criticality_id', 'Mission Criticality:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('biomed_mission_criticality_id', $mission_criticalities, $equipment->biomed_mission_criticality_id, ['class' => 'form-control selectpicker','id' => 'biomed_mission_criticality_idd','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('equipment_incident_history_id', 'Incident Histories:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('equipment_incident_history_id', $incident_histories, $equipment->equipment_incident_history_id, ['class' => 'form-control selectpicker','id' => 'equipment_incident_history_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                  {!! Form::label('baseline_date', 'Baseline date:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('baseline_date', $equipment->baseline_date, ['class' => 'form-control','id' => 'baseline_date']) !!}
                  </div>
            </div>




              <div class="form-group">
                  {!! Form::label('manufacturer_date', 'Installation Date:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('manufacturer_date', $equipment->manufacturer_date, ['class' => 'form-control','id' => 'manufacturer_date']) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('utilization', 'Annual Utilization %:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('utilization', $equipment->utilization, ['class' => 'form-control','id' => 'utilization']) !!}
                  </div>
              </div>



              <div class="form-group">
                  {!! Form::label('estimated_replacement_cost', 'Estimated Replacement Cost:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('estimated_replacement_cost', $equipment->estimated_replacement_cost, ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('estimated_deferred_maintenance_cost', 'Estimated Deferred Maintenance Cost per Year:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('estimated_deferred_maintenance_cost', $equipment->estimated_deferred_maintenance_cost, ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('identification_number', 'Equipment Identification Number:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('identification_number', $equipment->identification_number, ['class' => 'form-control']) !!}
                  </div>
              </div>

            <div class="form-group">
                {!! Form::label('is_warranty_availabled', 'Warranty:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('is_warranty_available', ['' => 'Please select',1 => 'Yes',0 => 'No'], $equipment->is_warranty_available, ['class' => 'form-control','id' => 'is_warranty_available']); !!}
                </div>
            </div>


              <div id="warranty_div" @if($equipment->is_warranty_available == 0) style="display:none" @endif>

                <div class="form-group">
                  {!! Form::label('warranty_start_date', 'Warranty Start Date:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('warranty_start_date', $equipment->warranty_start_date, ['class' => 'form-control','id' => 'warranty_start_date']) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('warranty_end_date', 'Warranty End Date:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('warranty_end_date', $equipment->warranty_end_date, ['class' => 'form-control','id' => 'warranty_end_date']) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('warranty_company_info', 'Warrant Company Info:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('warranty_company_info', $equipment->warranty_company_info, ['class' => 'form-control', 'placeholder' => 'Company name, point of contact, phone number, address, email of company providing warranty.','rows' => 3]) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('warranty_files_path', 'Warranty Files:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! HTML::dropzone('warranty_files_path',$equipment->warranty_files_path,'true','true') !!}
                  </div>
              </div>

                <div class="form-group">
                  {!! Form::label('warranty_description', 'Warranty Description:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('warranty_description', $equipment->warranty_description, ['class' => 'form-control','id' => 'warranty_description','rows' => 3]) !!}
                  </div>
                </div>

            </div>

            <div class="form-group">
                {!! Form::label('department_id', 'Department:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('department_id', $departments, $equipment->department_id, ['class' => 'form-control','id' => 'department_id','data-live-search' => "true"]); !!}
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('room_id', 'Room:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('room_id', App\Regulatory\BuildingDepartment::find($equipment->department_id)->rooms->pluck('room_number','id'), $equipment->room_id, ['class' => 'form-control','id' => 'room_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            {!! Form::hidden('equipment_id', $equipment->id); !!}






                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('equipment','Cancel', ['class' => 'btn btn-warning'] ) !!}
                        {!! Form::submit('Update Equipment', ['class' => 'btn btn-success pull-right'] ) !!}
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
        $("#hco_id").change(function(){
        
        var hco_id = $("#hco_id").val();

        $.ajax({
          type: 'POST',
          url: '{{ url('system-admin/accreditation/fetch/sites') }}',
          data: { '_token' : '{{ csrf_token() }}', 'hco_id': hco_id },
          beforeSend:function()
          {
            $('#accreditation_modal .callout').show();
          },
          success:function(data)
          {
            $('#site_id').html('');

            var html = '<option value="0">Select Site</option>';

            $.each(data.sites, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+' ('+value.address+' ) - #'+value.site_id+'</option>';
            });

            $('#site_id').append(html);
            $('#site_id').selectpicker('refresh');
            $('#accreditation_modal .callout').hide();
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



      });

      $("#site_id").change(function(){
        
        var site_id = $("#site_id").val();

        $.ajax({
          type: 'POST',
          url: '{{ url('system-admin/accreditation/fetch/buildings') }}',
          data: { '_token' : '{{ csrf_token() }}', 'site_id': site_id },
          beforeSend:function()
          {
            $('#accreditation_modal .callout').show();
          },
          success:function(data)
          {
            $('#building_id').html('');

            var html = '<option value="0">Select Building</option>';

            $.each(data.buildings, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+'- #'+value.building_id+'</option>';
            });

            $('#building_id').append(html);
            $('#building_id').selectpicker('refresh');
            $('#accreditation_modal .callout').hide();

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



      });

      $("#building_id").change(function(){
        
        var building_id = $("#building_id").val();

        $.ajax({
          type: 'POST',
          url: '{{ url('system-admin/accreditation/fetch/accreditation') }}',
          data: { '_token' : '{{ csrf_token() }}', 'building_id': building_id },
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            $('#accreditation_id').html('');

            var html = '<option value="0">Select Accreditation</option>';

            $.each(data.accreditations, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+'</option>';
            });

            $('#accreditation_id').append(html);
            $('#accreditation_id').selectpicker('render');
            

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

      });

    $("#manufacturer_date,#baseline_date,#warranty_start_date,#warranty_end_date").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d H:i",
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
                    $('#room_id').selectpicker('render');
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
                    $('#equipment_asset_category_id').selectpicker('render');
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

    $("#building_id").change(function(){

        if($(this).val() != 0)
        {
                $.ajax({
                type: 'POST',
                url: '{{ url('buildings/fetch/departments') }}',
                data: { '_token' : '{{ csrf_token() }}', 'building_id': $(this).val() },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    $('#department_id').html('');

                    var html = '<option value="0">Select Department</option>';

                    $.each(data.departments, function(index, value) {
                        html += '<option value="'+value.id+'">'+value.name+'</option>';
                    });

                    $('#department_id').append(html);
                    $('##department_id').selectpicker('render');
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
