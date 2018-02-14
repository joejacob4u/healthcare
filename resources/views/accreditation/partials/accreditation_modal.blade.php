<!-- Modal -->
<div id="accreditation_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Please Select a Building</h4>
      </div>
      <div class="modal-body">
      <div class="callout callout-warning" id="modal-messages" style="display:none">
            <p>Fetching Data. Please wait...</p>
        </div>

      {!! Form::open(['url' => 'system-admin/accreditation/set-building/', 'class' => '']) !!}
                <div class="form-group">
                    {!! Form::label('hco_id', 'HCO:', ['class' => 'control-label']) !!}
                    {!! Form::select('hco_id', $modal_hcos, Request::old('hco_id'), ['class' => 'form-control selectpicker','id' => 'hco_id']); !!}
                </div>
                <div class="form-group">
                    {!! Form::label('site_id', 'Site:', ['class' => 'control-label']) !!}
                    {!! Form::select('site_id', [], '', ['class' => 'form-control','id' => 'site_id','data-live-search' => "true"]); !!}
                </div>

                <div class="form-group">
                    {!! Form::label('building_id', 'Building:', ['class' => 'control-label']) !!}
                    {!! Form::select('building_id', [], '', ['class' => 'form-control','id' => 'building_id','data-live-search' => "true"]); !!}
                </div>

              <button type="submit" class="btn btn-primary">Set Building</button>
          {!! Form::close()  !!}

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
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
                html += '<option value="'+value.id+'">'+value.name+' ('+value.address+' )</option>';
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
                html += '<option value="'+value.id+'">'+value.name+'</option>';
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

      $("#accreditation_id").change(function(){
        
        var accreditation_id = $("#accreditation_id").val();

        $.ajax({
          type: 'POST',
          url: '{{ url('system-admin/accreditation/fetch/accreditation_requirements') }}',
          data: { '_token' : '{{ csrf_token() }}', 'accreditation_id': accreditation_id },
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            $('#accreditation_requirement_id').html('');

            var html = '<option value="0">Select Accreditation Requirement</option>';

            $.each(data.accreditation_requirements, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+'</option>';
            });

            $('#accreditation_requirement_id').append(html);
            $('#accreditation_requirement_id').selectpicker('render');

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


        </script>


