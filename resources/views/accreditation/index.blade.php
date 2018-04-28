@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Accreditation : '.$accreditation->name)
@section('page_description','Configure accreditations here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
    <div class="box">
      <div class="box-header with-border">
      <div class="callout callout-info">
          <h4>{{ $building->name }} - {{$building->site->name}}</h4>

          <p>{{ $building->site->address }}</p>
        </div>        
      </div>
      <div class="box-body">
                @if(isset($accreditation_requirement))
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  @foreach($accreditation_requirement->standardLabels->where('accreditation_id',$accreditation->id)->sortBy('label'); as $standard_label)
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$standard_label->id}}" aria-expanded="true" aria-controls="collapseOne">
                            <strong>{{$standard_label->label}}</strong> - <small>{{$standard_label->text}}</small>
                          </a>
                        </h4>
                      </div>
                    <div id="collapse-{{$standard_label->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">

                        <div class="panel panel-info">
                        <div class="panel-heading">
                          <h3 class="panel-title">Rationale for {{$standard_label->label}}</h3>
                        </div>
                        <div class="panel-body">
                          {{$standard_label->description}}
                        </div>
                        </div>

                        <div class="panel panel-success">
                        <div class="panel-heading">
                          <h3 class="panel-title">Elements of Performance for {{$standard_label->label}}</h3>
                        </div>
                        <div class="panel-body">
                        <table id="example" class="table table-striped">
                          <thead>
                              <tr>
                                  <th>EOP Name</th>
                                  <th>EOP Text</th>
                                  <th>Document</th>
                                  <th>Frequency</th>
                                  <th>Risk</th>
                                  <th>Progress</th>
                                  <th>Status</th>
                              </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>EOP Name</th>
                              <th>EOP Text</th>
                              <th>Document</th>
                              <th>Frequency</th>
                              <th>Risk</th>
                              <th>Progress</th>
                              <th>Status</th>
                          </tr>
                          </tfoot>
                          <tbody>
                            @foreach($standard_label->eops as $eop)
                              <tr>
                                <td>{{$eop->name}}</td>
                                <td>{{$eop->text}}</td>
                                <td>@if($eop->documentation == 1) {!! link_to('system-admin/accreditation/eop/'.$eop->id.'/documents','Upload',['class' => 'btn-xs btn-success']) !!} @else Nil @endif</td>
                                <td>{{$eop->frequency}}</td>
                                <td>@if($eop->risk == 1) Yes @else No @endif</td>
                                <td><small class="label pull-right bg-red">Initial : {{$eop->getFindingCount('initial')}}</small><small class="label pull-right bg-red">Non-Compliant : {{$eop->getFindingCount('non-compliant')}}</small><small class="label pull-right bg-yellow">Pending Verification : {{$eop->getFindingCount('pending_verification')}}</small><small class="label pull-right bg-blue">Issues Corrected Verify : {{$eop->getFindingCount('issues_corrected_verify')}}</small><small class="label pull-right bg-green">Compliant : {{$eop->getFindingCount('compliant')}}</small></td>
                                <td>{!! link_to('system-admin/accreditation/eop/status/'.$eop->id,'Status',['class' => 'btn-xs btn-primary']) !!}</td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                        </div>
                        </div>

                      </div>
                    </div>
                  </div>
                  @endforeach
                  </div>
                @endif
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>

    <!-- Start Modal-->
    <div id="requirementsModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Accreditation Requirements</h4>
          </div>
          <div class="modal-body">
            <ul></ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <!-- End Modal-->

    <script>
      function fetch(id)
      {
        $.ajax({
          type: 'POST',
          url: '{{ url('admin/accreditation/info') }}',
          data: { '_token' : '{{ csrf_token() }}', 'id': id },
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            $('#requirementsModal ul').html('');

            var html = '';

            $.each(data, function(index, value) {
                html += '<li><a href="accreditation-requirements/edit/'+value.id+'">'+value.name+'</a></li>';
            });

            $('#requirementsModal ul').append(html);

            $('#requirementsModal').modal('show');
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

      $("#hco_id").change(function(){
        
        var hco_id = $("#hco_id").val();

        $.ajax({
          type: 'POST',
          url: '{{ url('system-admin/accreditation/fetch/sites') }}',
          data: { '_token' : '{{ csrf_token() }}', 'hco_id': hco_id },
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            $('#site_id').html('');

            var html = '<option value="0">Select Site</option>';

            $.each(data.sites, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+' ('+value.address+' )</option>';
            });

            $('#site_id').append(html);
            $('#site_id').selectpicker('render');
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
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            $('#building_id').html('');

            var html = '<option value="0">Select Building</option>';

            $.each(data.buildings, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+'</option>';
            });

            $('#building_id').append(html);
            $('#building_id').selectpicker('render');

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

@endsection

