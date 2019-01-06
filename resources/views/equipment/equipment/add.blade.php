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
                {!! Form::label('equipment_asset_category_id', 'Equipment Asset Category:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('equipment_asset_category_id', [], '', ['class' => 'form-control','id' => 'equipment_asset_category_id','data-live-search' => "true"]); !!}
                </div>
            </div>


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
                      {!! Form::textarea('description', Request::old('description'), ['class' => 'form-control', 'placeholder' => 'Equipment Description (optional)','rows' => 3]) !!}
                  </div>
              </div>

             <div class="form-group">
                  {!! Form::label('equipment_pics_path', 'Equipment Pics:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! HTML::dropzone('equipment_pics_path','equipments/'.Auth::user()->healthsystem_id.'/'.strtotime('now'),'false','true') !!}
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
                {!! Form::label('is_warranty_availabled', 'Warranty:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('is_warranty_available', ['' => 'Please select',1 => 'Yes',0 => 'No'], '', ['class' => 'form-control','id' => 'is_warranty_available']); !!}
                </div>
            </div>

            <div id="warranty_div" style="display:none">

                <div class="form-group">
                  {!! Form::label('warranty_company_info', 'Warrant Company Info:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('warranty_company_info', Request::old('warranty_company_info'), ['class' => 'form-control', 'placeholder' => 'Company name, point of contact, phone number, address, email of company providing warranty.','rows' => 3]) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('warranty_files_path', 'Warranty Files:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! HTML::dropzone('warranty_files_path','equipments/warranty_files/'.Auth::user()->healthsystem_id.'/'.strtotime('now'),'false','true') !!}
                  </div>
              </div>

                <div class="form-group">
                  {!! Form::label('warranty_description', 'Warranty Description:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('warranty_description', Request::old('warranty_description'), ['class' => 'form-control','id' => 'warranty_description','rows' => 3]) !!}
                  </div>
                </div>

            </div>


                <div class="form-group">
                  {!! Form::label('preventive_maintenance_procedure', 'Preventive Maintenance Procedure:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('preventive_maintenance_procedure', Request::old('preventive_maintenance_procedure'), ['class' => 'form-control','id' => 'preventive_maintenance_procedure']) !!}
                  </div>
            </div>

            <div class="form-group">
                  {!! Form::label('preventive_maintenance_procedure_upload_path', 'Preventive Maintenance Procedure Files:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! HTML::dropzone('preventive_maintenance_procedure_upload_path','equipments/preventive_maintenance_procedure/'.Auth::user()->healthsystem_id.'/'.strtotime('now'),'false','true') !!}
                  </div>
              </div>


            <div class="form-group">
                  {!! Form::label('utilization', 'Annual Utilization %:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('utilization', Request::old('utilization'), ['class' => 'form-control','id' => 'utilization']) !!}
                  </div>
              </div>

              <div class="form-group">
                {!! Form::label('meet_current_oem_specifications', 'Meet current OEM specifications:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('meet_current_oem_specifications', ['' => 'Please Select',1 => 'Yes',0 => 'No'], Request::old('meet_current_oem_specifications'), ['class' => 'form-control','id' => 'meet_current_oem_specifications']); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('is_manufacturer_supported', 'Is manufacturer supported?:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('is_manufacturer_supported', ['' => 'Please Select', 1 => 'Yes',0 => 'No'], Request::old('is_manufacturer_supported'), ['class' => 'form-control','id' => 'is_manufacturer_supported']); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('impact_of_device_failure', ' Impact of Device Failure on Patient Health?:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('impact_of_device_failure', ['' => 'Please Select','minor' => 'Minor','major' => 'Major'], Request::old('impact_of_device_failure'), ['class' => 'form-control','id' => 'impact_of_device_failure']); !!}
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('is_maintenance_supported', 'Is maintenence supported?:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('is_manufacturer_supported', ['' => 'Please Select','yes' => 'Yes','no' => 'No','n/a' => 'N/A'], '', ['class' => 'form-control','id' => 'is_manufacturer_supported']); !!}
                </div>
            </div>


              <div class="callout callout-info" id="eop_div" style="display:none">

              </div>


            <div class="form-group">
                    {!! Form::label('frequency', 'Frequency:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!! Form::select('frequency', [0 => 'Please Select','no_frequency' => 'No Frequency','daily' => 'Daily','weekly' => 'Weekly','monthly' => 'Monthly','quarterly' => 'Quarterly','annually' => 'Annually','semi-annually' => 'Semi-anually','as_needed' => 'As Needed' ,'per_policy' => 'Per Policy','two-years' => 'Two Years', 'three-years' => 'Three Years', 'four-years' => 'Four Years', 'five-years' => 'Five Years', 'six-years' => 'Six Years'], Request::old('frequency'), ['class' => 'form-control']) !!}
                    </div>
                </div>



            <div class="form-group">
                {!! Form::label('equipment_maintenance_requirement_id', 'Maintenance Requirement Frequency:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('equipment_maintenance_requirement_id', $maintenance_requirements, '', ['class' => 'form-control selectpicker','id' => 'equipment_maintenance_requirement_id','data-live-search' => "true"]); !!}
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

    $("#manufacturer_date,#baseline_date,#warranty_start_date,#warranty_end_date").flatpickr({
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
