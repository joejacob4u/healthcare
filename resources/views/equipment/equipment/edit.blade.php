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
                      {!! Form::textarea('description', $equipment->description, ['class' => 'form-control', 'placeholder' => 'Equipment Description (optional)']) !!}
                  </div>
              </div>


            <div class="form-group">
                {!! Form::label('hco_id', 'HCO:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('hco_id', $hcos, $equipment->building->site->hco->id, ['class' => 'form-control selectpicker','id' => 'hco_id']); !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('site_id', 'Site:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('site_id', $equipment->building->site->hco->sites->pluck('name','id'), $equipment->building->site->id, ['class' => 'form-control','id' => 'site_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('building_id', 'Building:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('building_id', $equipment->building->site->buildings->pluck('name','id'), $equipment->building->id, ['class' => 'form-control','id' => 'building_id','data-live-search' => "true"]); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('equipment_category_id', 'Equipment Category:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('equipment_category_id', $categories, $equipment->equipment_category_id, ['class' => 'form-control','id' => 'equipment_category_id','data-live-search' => "true"]); !!}
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('equipment_asset_category_id', 'Equipment Asset Category Id:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('equipment_asset_category_id', App\Equipment\Category::find($equipment->equipment_category_id)->assetCategories->pluck('name','id'), $equipment->equipment_asset_category_id, ['class' => 'form-control','id' => 'equipment_asset_category_id','data-live-search' => "true"]); !!}
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('equipment_frequency_requirement_id', 'Requirement Frequency:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('equipment_frequency_requirement_id', $requirement_frequencies, $equipment->equipment_frequency_requirement_id, ['class' => 'form-control','id' => 'equipment_frequency_requirement_id','data-live-search' => "true"]); !!}
                </div>
            </div>




            <div class="form-group">
                {!! Form::label('maintenance_redundancy_id', 'Redundancy:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('maintenance_redundancy_id', $redundancies, $equipment->maintenance_redundancy_id, ['class' => 'form-control','id' => 'maintenance_redundancy_id','data-live-search' => "true"]); !!}
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
                  {!! Form::label('manufacturer_date', 'Manufacturer Date:', ['class' => 'col-lg-2 col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('manufacturer_date', $equipment->manufacturer_date, ['class' => 'form-control','id' => 'manufacturer_date']) !!}
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
                {!! Form::label('department_id', 'Department:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                {!! Form::select('department_id', $equipment->building->departments->pluck('name','id'), $equipment->department_id, ['class' => 'form-control','id' => 'department_id','data-live-search' => "true"]); !!}
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

    $("#manufacturer_date").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
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





</script>


@endsection
