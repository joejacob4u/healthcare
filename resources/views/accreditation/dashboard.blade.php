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
                <li><a data-toggle="pill" href="#documents_table">Building Documents</a></li>
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
                <table class="table table-bordered tab-pane">
                    <thead>
                        <th>Accreditation</th>
                        <th>Accreditation Standard</th>
                        <th>Baseline Date not Set</th>
                        <th>Missing Documents</th>
                        <th>Pending Verification</th>
                        <th>Compliant</th>
                        <th>Non Compliant</th>
                    </thead>
                    <tbody>
                        @foreach($hco->accreditations as $accreditation)
                            @foreach($accreditation->accreditationRequirements as $requirement)
                                @php 
                                 $all_missing_documents = [];
                                 $all_baseline_dates = [];
                                 $baseline_dates = $requirement->fetchMissingDocumentBaselineDatesByBuilding($accreditation->id); 
                                 $missing_documents = $requirement->fetchMissingSubmittedDocumentsByBuilding($accreditation->id);
                                 $pending_documents = $requirement->fetchDocumentsType($accreditation->id, 'pending_verification');
                                 $compliant_documents = $requirement->fetchDocumentsType($accreditation->id, 'compliant');
                                 $non_compliant_documents = $requirement->fetchDocumentsType($accreditation->id, 'non-compliant');
                                 $all_baseline_dates [] = $baseline_dates;
                                 $all_missing_documents [] = $missing_documents;
                                @endphp
                            <tr>
                            <td>{{ $accreditation->name }}</td>
                            <td>{{ $requirement->name }}</td>
                            <td>@if(count($baseline_dates) == 0)<small class="label bg-green">&#10004;</small>@else <small class="label bg-red">{{ count($baseline_dates) }}</small> @endif</td>
                            <td>@if(count($missing_documents) == 0)<small class="label bg-green">&#10004;</small>@else <small class="label bg-red">{{ count($missing_documents) }}</small> @endif</td>
                            <td>@if(count($pending_documents) == 0)<small class="label bg-green">&#10004;</small>@else <small class="label bg-red">{{ count($pending_documents) }}</small> @endif</td>
                            <td>@if(count($compliant_documents) == 0)<small class="label bg-green">&#10004;</small>@else <small class="label bg-red">{{ count($compliant_documents) }}</small> @endif</td>
                            <td>@if(count($non_compliant_documents) == 0)<small class="label bg-green">&#10004;</small>@else <small class="label bg-red">{{ count($non_compliant_documents) }}</small> @endif</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="documents_action_plan" class="tab-pane fade">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Standard Label</th>
                            <th>EOP #</th>
                            <th>EOP Text</th>
                            <th>Baseline Date Set</th>
                            <th>Document Submission Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($all_baseline_dates as $baseline_dates)
                            @foreach($baseline_dates as $baseline_date)
                                <tr>
                                    <td>{{$baseline_date->standardLabel->label}}</td>
                                    <td>{{$baseline_date->name}}</td>
                                    <td>{{$baseline_date->text}}</td>
                                    <td><small class="label bg-red">X</small></td>
                                    <td> N/A </td>
                                    <td>Baseline Not Set</td>
                                </tr>
                            @endforeach
                        @endforeach
                        @foreach($all_missing_documents as $missing_documents)
                            @foreach($missing_documents as $missing_document)
                            <tr>
                                <td>{{$missing_document->standardLabel->label}}</td>
                                <td>{{$missing_document->name}}</td>
                                <td>{{$missing_document->text}}</td>
                                <td><small class="label bg-green">&#10004;</small></td>
                                <td> {{ key($missing_document) }}</td>
                                <td>Pending Upload</td>
                            </tr>
                            @endforeach
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Standard Label</th>
                            <th>EOP #</th>
                            <th>EOP Text</th>
                            <th>Baseline Date Set</th>
                            <th>Document Submission Date</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
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

</script>


@endsection