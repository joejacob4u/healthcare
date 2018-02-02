@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Accreditations - <strong>'.$accreditation->name.'</strong>')
@section('page_description','Configure accreditations here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
    <div class="box">
      <div class="box-header with-border">
      {!! Form::open(['url' => 'system-admin/accreditation/'.$accreditation->id.'/accr-requirements/', 'class' => 'form-inline']) !!}
          <div class="form-group">
              {!! Form::label('hco_id', 'HCO:', ['class' => 'control-label']) !!}
              {!! Form::select('hco_id', $accreditation->hcos->where('healthsystem_id',Auth::guard('system_user')->user()->healthSystem->id)->pluck('facility_name','id')->prepend('Please select a hco', '0'), Request::old('hco_id'), ['class' => 'form-control','id' => 'hco_id']); !!}
          </div>
          <div class="form-group">
              {!! Form::label('site_id', 'Site:', ['class' => 'control-label']) !!}
              {!! Form::select('site_id', [], '', ['class' => 'form-control','id' => 'site_id']); !!}
          </div>

          <div class="form-group">
              {!! Form::label('building_id', 'Building:', ['class' => 'control-label']) !!}
              {!! Form::select('building_id', [], '', ['class' => 'form-control','id' => 'building_id']); !!}
          </div>
          <div class="form-group">
              {!! Form::label('accreditation_requirement_id', 'Accreditation Requirement:', ['class' => 'control-label']) !!}
              {!! Form::select('accreditation_requirement_id', $accreditation->accreditationRequirements->pluck('name','id')->prepend('Please select a requirement', '0'), Request::old('accreditation_requirement_id'), ['class' => 'form-control','id' => 'accreditation_requirement_id']); !!}
          </div>

            <button type="submit" class="btn btn-primary">Search</button>
        {!! Form::close()  !!}
      </div>
      <div class="box-body">
                @if(isset($accreditation_requirement))
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  @foreach($accreditation_requirement->standardLabels as $standard_label)
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
                                  <th>Standard Label</th>
                                  <th>Standard Text</th>
                                  <th>Document</th>
                                  <th>Risk</th>
                              </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Standard Label</th>
                              <th>Standard Text</th>
                              <th>Document</th>
                              <th>Risk</th>
                          </tr>
                          </tfoot>
                          <tbody>
                            @foreach($standard_label->eops as $eop)
                              <tr>
                                <td>{{$eop->name}}</td>
                                <td>{{$eop->text}}</td>
                                <td>@if($eop->documentation == 1) {!! link_to('#','Upload',['class' => 'btn-xs btn-success']) !!} @else Nil @endif</td>
                                <td>@if($eop->risk == 1) Yes @else No @endif</td>
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

            var html = '<option value="0">Select Site</option>';

            $.each(data.sites, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+'</option>';
            });

            $('#site_id').append(html);
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
        
        var hco_id = $("#hco_id").val();

        $.ajax({
          type: 'POST',
          url: '{{ url('system-admin/accreditation/fetch/buildings') }}',
          data: { '_token' : '{{ csrf_token() }}', 'hco_id': hco_id },
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            $('#requirementsModal ul').html('');

            var html = '';

            $.each(data, function(index, value) {
              console.log(value);
                //html += '<option><a href="accreditation-requirements/edit/'+value.id+'">'+value.name+'</a></option>';
            });

            $('#site_id').append(html);

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
