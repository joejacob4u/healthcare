@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','View Huddle')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="{{url('huddle')}}">Huddle</a></li>
    <li>View</li>
</ol>

<div class="row">
    <div class="col-sm-6">
        <div class="callout callout-info">
            <h4>Care Team : {{$huddle->careTeam->name}}</h4>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="callout callout-warning">
            <h4>Leader : {{$huddle->careTeam->leader->name}}</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="callout callout-info">
            <h4>Location : {{$huddle->careTeam->location}}</h4>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="callout callout-warning">
            <h4>Recorder of Data : {{$huddle->recorderOfData->name}}</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="callout callout-success">
            <h4>Date and Time : {{$huddle->date->toDayDateTimeString()}}</h4>
        </div>
    </div>
</div>


{!! Form::open(['url' => 'huddle/'.$huddle->id, 'class' => 'form-horizontal']) !!}



@if($huddle->recorderOfData->id == Auth::user()->id || $huddle->careTeam->alternative_recorder_of_data_user_id == Auth::user()->id)

    <div class="list-group">
        <a href="#" class="list-group-item active">Attendees</a>
        @foreach($huddle->users as $user)
            <a href="#" class="list-group-item">{{$user->name}}</a>
        @endforeach
    </div>


    <div class="form-group">
        {!! Form::label('attendance[]', 'Attendance:', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('attendance[]', $users, Request::old('attendance'), ['class' => 'form-control selectpicker','id' => 'attendance','multiple' => true]); !!}
        </div>
    </div>

    @if($huddle->has_no_capacity_constraint == 0)

        <div class="list-group">
            <a href="#" class="list-group-item active">Capacity</a>
            <a href="#" class="list-group-item">Number of Available Beds (%): {{$huddle->no_of_available_beds}}</a>
            <a href="#" class="list-group-item">Number of Occupied Beds (%) : {{$huddle->no_of_occupied_beds}}</a>
            <a href="#" class="list-group-item">Number of Out of Commission Beds (%) : {{$huddle->no_of_out_of_commission_beds}}</a>
        </div>

    @endif

    <div class="form-group">
        {!! Form::label('no_of_available_beds', 'Number of Available Beds:', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
        {!! Form::text('no_of_available_beds', $huddle->no_of_available_beds, ['class' => 'form-control','id' => 'no_of_available_beds']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('no_of_occupied_beds', 'Number of Occupied Beds:', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
        {!! Form::text('no_of_occupied_beds', $huddle->no_of_occupied_beds, ['class' => 'form-control','id' => 'no_of_occupied_beds']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('no_of_out_of_commission_beds', 'Number of Out of Commission Beds:', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
        {!! Form::text('no_of_out_of_commission_beds', $huddle->no_of_out_of_commission_beds, ['class' => 'form-control','id' => 'no_of_out_of_commission_beds']) !!}
        </div>
    </div>

@else

    <div class="list-group">
        <a href="#" class="list-group-item active">Attendees</a>
        @foreach($huddle->users as $user)
            <a href="#" class="list-group-item">{{$user->name}}</a>
        @endforeach
    </div>

    <div class="box box-solid">
        <div class="box-header with-border">
            <i class="fa fa-text-width"></i>
            <h3 class="box-title">Capacity</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <dl>
                <dt>Number of Available Beds</dt>
                <dd>{{$huddle->no_of_available_beds}}</dd>
                <dt>Number of Occupied Beds</dt>
                <dd>{{$huddle->no_of_occupied_beds}}</dd>
                <dt>Out of Commission Beds</dt>
                <dd>{{$huddle->no_of_out_of_commission_beds}}</dd>
            </dl>
        </div>
        <!-- /.box-body -->
    </div>
@endif

<div class="list-group">
    <a href="#" class="list-group-item active">ILSM Education</a>

    @if($ilsm_assessments->isEmpty())
        <a href="#" class="list-group-item"><span class="label label-danger">N/A</span></a>
    @else
        <a href="#" class="list-group-item"><span class="label label-success">New Safety Events since last Huddle</span></a>
        @foreach($ilsm_assessments->whereNotIn('ilsm_assessment_status_id',[1,2,8])->where('created_at', \Carbon\Carbon::today()->subDays(1)) as $ilsm_assessment)
            <a href="{{url('/equipment/ilsm-assessment/'.$ilsm_assessment->id)}}" class="list-group-item">ILSM Assessment for WO# {{$ilsm_assessment->work_order->identifier}}</a>
        @endforeach

        <a href="#" class="list-group-item"><span class="label label-warning">Open Safety Events</span></a>
        @foreach($ilsm_assessments->whereNotIn('ilsm_assessment_status_id',[1,2,7,8]) as $ilsm_assessment)
            <a href="{{url('/equipment/ilsm-assessment/'.$ilsm_assessment->id)}}" class="list-group-item">ILSM Assessment for WO# {{$ilsm_assessment->work_order->identifier}}</a>
        @endforeach
    @endif

</div>

<div class="list-group">
    <a href="#" class="list-group-item active">Serious Safety Events</a>

    @if($assessments->where('assessment_checklist_type_id',97)->isEmpty())
        <a href="#" class="list-group-item"><span class="label label-danger">N/A</span></a>
    @else
        <a href="#" class="list-group-item"><span class="label label-success">New Serious Safety Events since last Huddle</span></a>
        @foreach($assessments->where('assessment_checklist_type_id',97)->where('created_at', \Carbon\Carbon::today()->subDays(1)) as $assessment)
            @foreach($assessment_question_evaluations->where('assessment_id',$assessment->id) as $evaluation)
                <a href="#" class="list-group-item"><strong>{{$evaluation->user->name}} <i>evaluated</i> {{$evaluation->finding['comment']}} </strong></a>
            @endforeach
        @endforeach

    @endif

</div>

<div class="list-group">
    <a href="#" class="list-group-item active">Hospital Acquired Infections</a>

    @if($assessments->where('assessment_checklist_type_id',93)->isEmpty())
        <a href="#" class="list-group-item"><span class="label label-danger">N/A</span></a>
    @else
        <a href="#" class="list-group-item"><span class="label label-success">New Hospital Acquired Infections Events since last Huddle</span></a>
        @foreach($assessments->where('assessment_checklist_type_id',93)->where('created_at', \Carbon\Carbon::today()->subDays(1)) as $assessment)
            @foreach($assessment_question_evaluations->where('assessment_id',$assessment->id) as $evaluation)
                <a href="#" class="list-group-item"><strong>{{$evaluation->user->name}} <i>evaluated</i> {{$evaluation->finding['comment']}} </strong></a>
            @endforeach
        @endforeach
    @endif
</div>

<div class="list-group">
    <a href="#" class="list-group-item active">Downtime of Major Equipment</a>

    @if($assessments->where('assessment_checklist_type_id',92)->isEmpty())
        <a href="#" class="list-group-item"><span class="label label-danger">N/A</span></a>
    @else
        <a href="#" class="list-group-item"><span class="label label-success">New Downtime of Major Equipment Events since last Huddle</span></a>
        @foreach($assessments->where('assessment_checklist_type_id',92)->where('created_at', \Carbon\Carbon::today()->subDays(1)) as $assessment)
            @foreach($assessment_question_evaluations->where('assessment_id',$assessment->id) as $evaluation)
                <a href="#" class="list-group-item"><strong>{{$evaluation->user->name}} <i>evaluated</i> {{$evaluation->finding['comment']}} </strong></a>
            @endforeach
        @endforeach

    @endif
</div>

<div class="list-group">
    <a href="#" class="list-group-item active">Power Outages</a>

    @if($assessments->where('assessment_checklist_type_id',96)->isEmpty())
        <a href="#" class="list-group-item"><span class="label label-danger">N/A</span></a>
    @else
        <a href="#" class="list-group-item"><span class="label label-success">New Power Outages Events since last Huddle</span></a>
        @foreach($assessments->where('assessment_checklist_type_id',96)->where('created_at', \Carbon\Carbon::today()->subDays(1)) as $assessment)
            @foreach($assessment_question_evaluations->where('assessment_id',$assessment->id) as $evaluation)
                <a href="#" class="list-group-item"><strong>{{$evaluation->user->name}} <i>evaluated</i> {{$evaluation->finding['comment']}} </strong></a>
            @endforeach
        @endforeach

    @endif
</div>

<div class="list-group">
    <a href="#" class="list-group-item active">Patient Harm or Injuries</a>

    @if($assessments->where('assessment_checklist_type_id',94)->isEmpty())
        <a href="#" class="list-group-item"><span class="label label-danger">N/A</span></a>
    @else
        <a href="#" class="list-group-item"><span class="label label-success">Patient Harm or Injuries Events since last Huddle</span></a>
        @foreach($assessments->where('assessment_checklist_type_id',94)->where('created_at', \Carbon\Carbon::today()->subDays(1)) as $assessment)
            @foreach($assessment_question_evaluations->where('assessment_id',$assessment->id) as $evaluation)
                <a href="#" class="list-group-item"><strong>{{$evaluation->user->name}} <i>evaluated</i> {{$evaluation->finding['comment']}} </strong></a>
            @endforeach
        @endforeach
    @endif
</div>	


<div class="list-group">
    <a href="#" class="list-group-item active">Pharmacy Shortage</a>

    @if($assessments->where('assessment_checklist_type_id',95)->isEmpty())
        <a href="#" class="list-group-item"><span class="label label-danger">N/A</span></a>
    @else
        <a href="#" class="list-group-item"><span class="label label-success">New Pharmacy Shortage Events since last Huddle</span></a>
        @foreach($assessments->where('assessment_checklist_type_id',95)->where('created_at', \Carbon\Carbon::today()->subDays(1)) as $assessment)
            @foreach($assessment_question_evaluations->where('assessment_id',$assessment->id) as $evaluation)
                <a href="#" class="list-group-item"><strong>{{$evaluation->user->name}} <i>evaluated</i> {{$evaluation->finding['comment']}} </strong></a>
            @endforeach
        @endforeach
    @endif
</div>



{!! Form::hidden('recorder_of_data_user_id', Auth::user()->id, ['id' => 'recorder_of_data_user_id']) !!}
{!! Form::hidden('healthsystem_id', session('healthsystem_id'),['id' => 'healthsystem_id']) !!}


<!-- Submit Button -->
<div class="form-group">
    <div class="col-lg-10 col-lg-offset-2">
        {!! Form::submit('Update Huddle', ['class' => 'btn btn-success pull-right'] ) !!}
    </div>
</div>

</fieldset>

{!! Form::close()  !!}

    <script>

    $('.date').flatpickr({
         enableTime: true,
         dateFormat: "Y-m-d H:i:S",
    });

    $('#has_no_capacity_constraint').change(function(){
        
        if($(this).prop('checked'))
        {
            $('#constraint_div').hide();
        }
        else
        {
            $('#constraint_div').show();
        }
    });


    </script>

@endsection
