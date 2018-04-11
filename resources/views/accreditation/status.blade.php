@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','EOP Status - <strong>'.$building->name.'</strong>')
@section('page_description','Status.')



@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
          <li><a href="{{url('system-admin/accreditation/<?php echo session('accreditation_id'); ?>/accreditation_requirement/<?php echo session('accreditation_requirement_id'); ?>')}}"><i class="fa fa-dashboard"></i> Accreditation Requirement</a></li>
          <li class="active">EOP Status</li>
        </ol>

<div class="callout callout-info">
    <h4>EOP : {{$eop->name}}</h4>
    <p>{{$eop->text}}</p>
</div>

<div class="box">
    <div class="box-header with-border">
    <h3 class="box-title">Findings</h3>
    <div class="box-tools pull-right">
        <a href="{{url('system-admin/accreditation/eop/status/'.$eop->id.'/finding/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Finding</a>
    </div>

    </div>
    <div class="box-body">
    <table id="example" class="table table-striped">
            <thead>
                <tr>
                    <th>Finding</th>
                    <th>Status</th>
                    <th>Date of Finding</th>
                    <th>Last Status Update</th>
                    <th>Assigned To</th>
                    <th>Edit</th>
                    <th>View Activity</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Finding</th>
                    <th>Status</th>
                    <th>Date of Finding</th>
                    <th>Last Status Update</th>
                    <th>Assigned To</th>
                    <th>Edit</th>
                    <th>View Activity</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($findings as $finding)
                <tr>
                    <td>{{$finding->description}}</td>
                    <td>{{$finding->status}}</td>
                    <td>{{ date('F j, Y, g:i a',strtotime($finding->created_at)) }}</td>
                    <td>@if(!is_null($finding->comments->last())){{ date('F j, Y, g:i a',strtotime($finding->comments->last()->created_at)) }} @else {{ date('F j, Y, g:i a',strtotime($finding->created_at)) }} @endif</td>
                    <td>@if(!is_null($finding->comments->last())){{ App\User::find($finding->comments->last()->assigned_user_id)->name }} @else Nil @endif</td>
                    <td>{!! link_to('system-admin/accreditation/eop/status/'.$eop->id.'/finding/edit/'.$finding->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                    <td>{!! link_to('system-admin/accreditation/eop/status/'.$eop->id.'/finding/'.$finding->id,'View Activity',['class' => 'btn-xs btn-primary']) !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
    Footer
    </div>
    <!-- /.box-footer-->
</div>


@endsection
