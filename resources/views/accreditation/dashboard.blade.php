@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Accreditation Dashboard')
@section('page_description','')

@section('content')
@if(!empty(session('building_id')))

    <div class="box box-solid box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Findings and Documents Report for HCO :<strong> {{$hco->facility_name}}({{$hco->hco_id}})</strong></h3>
        </div>
        <div class="box-body">
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#findings_table">HCO Findings</a></li>
                <li><a data-toggle="pill" href="#safer_action_plan">Findings Action Plan</a></li>
                <li><a data-toggle="pill" href="#documents_table">HCO Documents</a></li>
                <li><a data-toggle="pill" href="#documents_action_plan">Documents Action Plan</a></li>
                <li><a data-toggle="pill" href="#safer_matrix_table">Safer Matrix</a></li>
            </ul>

            <div class="tab-content">
            <div id="findings_table" class="tab-pane fade in active">
                <table class="table table-bordered tab-pane active" data-show="all" type="yajra" id="findings_table_data">
                    <thead>
                        <th>Accreditation</th>
                        <th>Accreditation Standard</th>
                        <th>Pending Verification</th>
                        <th>Issues Corrected Verify</th>
                        <th>Initial Findings</th>
                        <th>Non Compliant</th>
                    </thead>
                </table>
            </div>
            <div id="documents_table" class="tab-pane fade">
                <table class="table table-bordered tab-pane" id="hco_documents_table" type="yajra">
                    <thead>
                        <th>Accreditation</th>
                        <th>Accreditation Standard</th>
                        <th>Baseline Date not Set</th>
                        <th>Missing Documents</th>
                        <th>Pending Verification</th>
                        <th>Compliant</th>
                        <th>Non Compliant</th>
                    </thead>
                </table>
            </div>
            <div id="documents_action_plan" class="tab-pane fade">
                <div class="box-tools pull-right">
                    <a href="/system-admin/dashboard/documents/export/action-plan" type="button" class="btn btn-warning">Export</a>
                </div>
                <br/>
                <p><strong>Last updated at {{\Carbon\Carbon::now()->toDayDateTimeString() }}</strong></p>
                <table class="table table-striped" id="document-action-plan-table" type="yajra">
                    <thead>
                            <th>Site</th>
                            <th>Site ID</th>
                            <th>Building</th>
                            <th>Building ID<th>
                            <th>Accreditation</th>
                            <th>Standard Label</th>
                            <th>EOP #</th>
                            <th>EOP Text</th>
                            <th>Baseline Date Set</th>
                            <th>Document Submission Date</th>
                            <th>Status</th>
                    </thead>
                </table>
            </div>
            <div id="safer_matrix_table" class="tab-pane fade">
                <br>
                <div class="callout callout-danger">
                    <h4>Immediate Threat to Life</h4>
                    <p>Follows current ITL Process</p>
                    <ul>
                    @foreach($safer_matrix['itl'] as $eop)
                        <li>{{$eop->eop->standardLabel->label}} - {{$eop->eop->name}}</li>
                    @endforeach
                    </ul>
                </div>

                <table class="table table-bordered tab-pane" type="yajra">
                    <thead>
                        <th>Intensity</th>
                        <th>Limited</th>
                        <th>Pattern</th>
                        <th>Widespread</th>
                    </thead>
                    <tbody>
                        <tr>
                         <td><a href="#" title="High:" data-toggle="popover" data-trigger="hover" data-placement="top" data-content=" Harm could happen at any time.Could directly lead to harm without the need for other significant circumstances or failures.If the deficiency continues, it would be likely that harm could happen at any time to any patient (or did I actually happen).">High</a</td>
                         <td class="bg-red-active color-palette">@foreach($safer_matrix['high_limited'] as $eop) {{$eop->eop->standardLabel->label}} - {{$eop->eop->name}} <br>  @endforeach</td>
                         <td class="bg-red-active color-palette">@foreach($safer_matrix['high_pattern'] as $eop) {{$eop->eop->standardLabel->label}} - {{$eop->eop->name}} <br>  @endforeach</td>
                         <td class="bg-red-active color-palette">@foreach($safer_matrix['high_widespread'] as $eop) {{$eop->eop->standardLabel->label}} - {{$eop->eop->name}} <br>  @endforeach</td>
                        </tr>
                        <tr>
                         <td><a href="#" title="Moderate:" data-toggle="popover" data-trigger="hover" data-placement="top" data-content=" Harm could happen occasionally. Could cause harm directly, but more likely to cause harm as a contributing factor in the precence of special circumstances or additional failures.If the deficiency continues, it would be possible that harm could occur but only in certain situations and/or patients.">Moderate</a></td>
                         <td class="bg-yellow color-palette">@foreach($safer_matrix['moderate_limited'] as $eop) {{$eop->eop->standardLabel->label}} - {{$eop->eop->name}} <br>  @endforeach</td>
                         <td class="bg-yellow-active color-palette">@foreach($safer_matrix['moderate_pattern'] as $eop) {{$eop->eop->standardLabel->label}} - {{$eop->eop->name}} <br>  @endforeach</td>
                         <td class="bg-yellow-active color-palette">@foreach($safer_matrix['moderate_widespread'] as $eop) {{$eop->eop->standardLabel->label}} - {{$eop->eop->name}} <br>  @endforeach</td>
                        </tr>
                        <tr>
                         <td><a href="#" title="Low" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Harm could happen, but would be rare. Undermines safety/quality or contributes to an unsafe environment, but very unlikely to directly contribute to harm.">Low</a</td>
                         <td class="bg-yellow disabled color-palette">@foreach($safer_matrix['low_limited'] as $eop) {{$eop->eop->standardLabel->label}} - {{$eop->eop->name}} <br>  @endforeach</td>
                         <td class="bg-yellow color-palette">@foreach($safer_matrix['low_pattern'] as $eop) {{$eop->eop->standardLabel->label}} - {{$eop->eop->name}} <br>  @endforeach</td>
                         <td class="bg-yellow color-palette">@foreach($safer_matrix['low_widespread'] as $eop) {{$eop->eop->standardLabel->label}} - {{$eop->eop->name}} <br>  @endforeach</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="safer_action_plan" class="tab-pane fade">
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
                <table id="action-plan-table" class="table table-striped" type="yajra">
                    <thead>
                        <tr>
                            <th>Site</th>
                            <th>Building</th>
                            <th>Standard Label</th>
                            <th>EOP #</th>
                            <th>EOP Text</th>
                            <th>Finding Date</th>
                            <th>Finding</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Site</th>
                            <th>Building</th>
                            <th>Standard Label</th>
                            <th>EOP #</th>
                            <th>EOP Text</th>
                            <th>Finding Date</th>
                            <th>Finding</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                </table>
        </div>

        </div>
        <div class="box-footer">
            As of {{ \Carbon\Carbon::now()->toDayDateTimeString() }}
        </div>
</div>

@endif

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});

$('#action-plan-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,

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
            {data: 'eop_name', name: 'eop.name'},
            {data: 'eop_text', name: 'eop.text'},
            {data: 'finding_date', name: 'eop_findings.created_at'},
            {data: 'finding_button', name: 'eop_findings.eop_id'},
            {data: 'status', name: 'eop_findings.status'},
            ]
    });

    $('#findings_table_data').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,

        ajax: {
            url: '{{url('system-admin/findings/fetch/report')}}',
            type: "POST",
            data: function (data) {
                data._token = '{{ csrf_token() }}'
            }
        },

        initComplete: function(settings, json) {
            $('[data-toggle="popover"]').popover();
        },

        columns: [
            {data: 'accreditation', name: 'accreditation'},
            {data: 'accreditation_standard', name: 'accreditation_standard'},
            {data: 'pending_verification_count', name: 'pending_verification_count'},
            {data: 'issues_corrected_verify_count', name: 'issues_corrected_verify_count'},
            {data: 'initial_count', name: 'initial_count'},
            {data: 'non_compliant', name: 'non_compliant'},
            ]
    });

    $('#hco_documents_table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,

        ajax: {
            url: '{{url('system-admin/dashboard/documents/fetch/report')}}',
            type: "POST",
            data: function (data) {
                data._token = '{{ csrf_token() }}'
            }
        },

        initComplete: function(settings, json) {
            $('[data-toggle="popover"]').popover();
        },

        columns: [
            {data: 'accreditation', name: 'accreditation'},
            {data: 'accreditation_standard', name: 'accreditation_standard'},
            {data: 'baseline_missing_dates', name: 'baseline_missing_dates'},
            {data: 'pending_upload', name: 'pending_upload'},
            {data: 'pending_verification', name: 'pending_verification'},
            {data: 'compliant', name: 'compliant'},
            {data: 'non_compliant', name: 'non_compliant'},
        ]
    });

        $('#document-action-plan-table').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            pageLength: 100,
            scrollX: true,

        ajax: {
            url: '{{url('system-admin/dashboard/documents/fetch/action-plan')}}',
            type: "POST",
            data: function (data) {
                data._token = '{{ csrf_token() }}'
            }
        },

        initComplete: function(settings, json) {
            $('[data-toggle="popover"]').popover();
        },

        columns: [
            {data: 'site', name: 'site'},
            {data: 'site_id', name: 'site_id'},
            {data: 'building', name: 'building'},
            {data: 'building_id', name: 'building_id'},
            {data: 'accreditation', name: 'accreditation'},
            {data: 'standard_label', name: 'standard_label'},
            {data: 'eop_number', name: 'eop_number'},
            {data: 'eop_text', name: 'eop_text'},
            {data: 'is_baseline_date_set', name: 'is_baseline_date_set'},
            {data: 'documentation_submission_date', name: 'documentation_submission_date'},
            {data: 'status', name: 'status'},
        ]
    });



</script>


@endsection