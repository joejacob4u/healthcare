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
            <h3 class="box-title">Findings Report</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
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
                        <td>{{ $requirement->countFindingByStatus('pending_verification',$accreditation->id) }}</td>
                        <td>{{ $requirement->countFindingByStatus('issues_corrected_verify',$accreditation->id) }}</td>
                        <td>{{ $requirement->countFindingByStatus('initial',$accreditation->id) }}</td>
                        <td>{{ $requirement->countFindingByStatus('non-compliant',$accreditation->id) }}</td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
        </table>
        </div>
        <div class="box-footer">
            As of {{ \Carbon\Carbon::now()->toDayDateTimeString() }}
        </div>
</div>

@endif



@endsection