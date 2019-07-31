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

{!! Form::open(['url' => 'huddle', 'class' => 'form-horizontal']) !!}



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
            {!! Form::select('attendance[]', $users->prepend('Please Select',''), Request::old('attendance'), ['class' => 'form-control selectpicker','id' => 'attendance','multiple' => true]); !!}
        </div>
    </div>

    <div class="list-group">
        <a href="#" class="list-group-item active">Capacity</a>
        <a href="#" class="list-group-item">Number of Available Beds : {{$huddle->no_of_available_beds}}</a>
        <a href="#" class="list-group-item">Number of Occupied Beds : {{$huddle->no_of_occupied_beds}}</a>
        <a href="#" class="list-group-item">Number of Out of Commission Beds : {{$huddle->no_of_out_of_commission_beds}}</a>
    </div>

    <div class="form-group">
        {!! Form::label('no_of_available_beds', 'Number of Available Beds:', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
        {!! Form::text('no_of_available_beds', Request::old('no_of_available_beds'), ['class' => 'form-control','id' => 'no_of_available_beds']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('no_of_occupied_beds', 'Number of Occupied Beds:', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
        {!! Form::text('no_of_occupied_beds', Request::old('no_of_occupied_beds'), ['class' => 'form-control','id' => 'no_of_occupied_beds']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('no_of_out_of_commission_beds', 'Number of Out of Commission Beds:', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
        {!! Form::text('no_of_out_of_commission_beds', Request::old('no_of_out_of_commission_beds'), ['class' => 'form-control','id' => 'no_of_out_of_commission_beds']) !!}
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
