@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Action Plan')
@section('page_description',$hco->facility_name)

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"><strong>HCO Action Plan</strong> : {{$hco->facility_name}} - #{{ $hco->hco_id }}</h3>

        <div class="box-tools pull-right">
            <div class="btn-group">
                  <button type="button" class="btn btn-warning">Export</button>
                  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{url('system-admin/findings/export/hco')}}">Current HCO</a></li>
                    <li><a href="{{url('system-admin/findings/export')}}">Entire HealthCare System</a></li>
                  </ul>
                </div>
        </div>
      </div>
      <div class="box-body">
        <table id="action-plan-table" class="table table-striped" type="yajra">
                <thead>
                    <tr>
                        <th>Site</th>
                        <th>Building</th>
                        <th>Standard Label</th>
                        <th>Standard Label Text</th>
                        <th>EOP #</th>
                        <th>EOP Text</th>
                        <th>Finding</th>
                        <th>Measure of Success</th>
                        <th>Benefit</th>
                        <th>Plan of Action</th>
                        <th>Last Assigned To</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Site</th>
                      <th>Building</th>
                      <th>Standard Label</th>
                      <th>Standard Label Text</th>
                      <th>EOP Name</th>
                      <th>EOP Text</th>
                      <th>Finding</th>
                      <th>Measure of Success</th>
                      <th>Benefit</th>
                      <th>Plan of Action</th>
                      <th>Last Assigned To</th>
                      <th>Due Date</th>
                      <th>Status</th>
                    </tr>
                </tfoot>
            </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>

    <script>

    $('#action-plan-table').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ajax: {
            url: '{{url('system-admin/findings/action-plan')}}',
            type: "POST",
            data: function (data) {
                data._token = '{{ csrf_token() }}'
            }
        },

        initComplete: function(settings, json) {
            $('[data-toggle="popover"]').popover();
        },

        columns: [
            {data: 'site_name', name: 'sites.name'},
            {data: 'building_name', name: 'buildings.name'},
            {data: 'label', name: 'standard_label.label'},
            {data: 'label_text', name: 'standard_label.text'},
            {data: 'eop_name', name: 'eop.name'},
            {data: 'eop_text', name: 'eop.text'},
            {data: 'description', name: 'eop_findings.description'},
            {data: 'measure_of_success', name: 'eop_findings.measure_of_success'},
            {data: 'benefit', name: 'eop_findings.benefit'},
            {data: 'plan_of_action', name: 'eop_findings.plan_of_action'},
            {data: 'last_assigned_name', name: 'eop_findings.last_assigned_user_id'},
            {data: 'due_date', name: 'eop_findings.measure_of_success_date'},
            {data: 'status', name: 'eop_findings.status'}]
    });



    </script>


@endsection

