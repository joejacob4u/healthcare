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
                <li class="active"><a data-toggle="pill" href="#findings_table">Findings</a></li>
                <li><a data-toggle="pill" href="#documents_table">Documents</a></li>
                <li><a data-toggle="pill" href="#safer_matrix_table">Safer Matrix</a></li>
            </ul>

            <div class="tab-content">
            <div id="findings_table" class="tab-pane fade in active">
                <table class="table table-bordered tab-pane active" data-show="all">
                    <thead>
                        <th>Accreditation</th>
                        <th>Accreditation Standard</th>
                        <th>Pending Verification</th>
                        <th>Issues Corrected Verify</th>
                        <th>Initial Findings</th>
                        <th>Non Compliant</th>
                    </thead>
                    <tbody>
                        @foreach($hco->accreditations as $accreditation)
                            @foreach($accreditation->accreditationRequirements as $requirement)
                            <tr>
                                <td>{{ $accreditation->name }}</td>
                                <td>{{ $requirement->name }}</td>
                                <td>@if($requirement->countFindingByStatus('pending_verification',$accreditation->id) == 0)<small class="label bg-green">&#10004;</small>@else <small class="label bg-red">{{ $requirement->countFindingByStatus('pending_verification',$accreditation->id)}}</small> @endif</td>
                                <td>@if($requirement->countFindingByStatus('issues_corrected_verify',$accreditation->id) == 0)<small class="label bg-green">&#10004;</small>@else <small class="label bg-red">{{ $requirement->countFindingByStatus('issues_corrected_verify',$accreditation->id)}}</small> @endif</td>
                                <td>@if($requirement->countFindingByStatus('initial',$accreditation->id) == 0)<small class="label bg-green">&#10004;</small>@else <small class="label bg-red">{{ $requirement->countFindingByStatus('initial',$accreditation->id)}}</small> @endif</td>
                                <td>@if($requirement->countFindingByStatus('non-compliant',$accreditation->id) == 0)<small class="label bg-green">&#10004;</small>@else <small class="label bg-red">{{ $requirement->countFindingByStatus('non-compliant',$accreditation->id)}}</small> @endif</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="documents_table" class="tab-pane fade">
                <table class="table table-bordered tab-pane">
                    <thead>
                        <th>Accreditation</th>
                        <th>Accreditation Standard</th>
                        <th>Initial Findings</th>
                        <th>Non Compliant</th>
                    </thead>
                    <tbody>
                        @foreach($hco->accreditations as $accreditation)
                            @foreach($accreditation->accreditationRequirements as $requirement)
                            <tr>
                            <td>{{ $accreditation->name }}</td>
                            <td>{{ $requirement->name }}</td>
                            <td>@if($requirement->countDocumentsByStatus('initial',$accreditation->id) == 0)<small class="label bg-green">&#10004;</small>@else <small class="label bg-red">{{ $requirement->countDocumentsByStatus('initial',$accreditation->id)}}</small> @endif</td>
                            <td>@if($requirement->countDocumentsByStatus('non-compliant',$accreditation->id) == 0)<small class="label bg-green">&#10004;</small>@else <small class="label bg-red">{{ $requirement->countDocumentsByStatus('non-compliant',$accreditation->id)}}</small> @endif</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
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
                         <td class="bg-yellow-active color-palette">@foreach($safer_matrix['low_pattern'] as $eop) {{$eop->eop->standardLabel->label}} - {{$eop->eop->name}} <br>  @endforeach</td>
                         <td class="bg-yellow-active color-palette">@foreach($safer_matrix['low_widespread'] as $eop) {{$eop->eop->standardLabel->label}} - {{$eop->eop->name}} <br>  @endforeach</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
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
</script>


@endsection