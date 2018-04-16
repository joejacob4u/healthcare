@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Action Plan')
@section('page_description','Action plan data table.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Action Plan</h3>

        <div class="box-tools pull-right">
            <a href="{{url('system-admin/findings/export')}}" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Export</a>
        </div>
      </div>
      <div class="box-body">
        <table id="action-plan-table" class="table table-striped" type="yajra">
                <thead>
                    <tr>
                        <th>Healthcare System</th>
                        <th>HCO</th>
                        <th>Site</th>
                        <th>Building</th>
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
                      <th>Healthcare System</th>
                      <th>HCO</th>
                      <th>Site</th>
                      <th>Building</th>
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
        ajax: {
            url: '{{url('system-admin/findings/action-plan')}}',
            type: "POST",
            data: function (data) {
                data._token = '{{ csrf_token() }}'
            }
        },
        columns: [
            {data: 'healthcare_system', name: 'healthsystem.healthcare_system'},
            {data: 'hco', name: 'hco.facility_name'},
            {data: 'site_name', name: 'sites.name'},
            {data: 'building_name', name: 'buildings.name'},
            {data: 'description', name: 'eop_findings.description'},
            {data: 'measure_of_success', name: 'eop_findings.measure_of_success'},
            {data: 'benefit', name: 'eop_findings.benefit'},
            {data: 'plan_of_action', name: 'eop_findings.plan_of_action'},
            {data: 'last_assigned_name', name: 'eop_findings.last_assigned_user_id'},
            {data: 'due_date', name: 'eop_findings.measure_of_success_date'},
            {data: 'status', name: 'eop_findings.status'}
        ]
    });


    </script>

@endsection

