@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','EOP Status - <strong>'.$building->name.'</strong>')
@section('page_description','Status.')



@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

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
                    <th>View</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Finding</th>
                    <th>Status</th>
                    <th>View</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($findings as $finding)
                <tr>
                    <td>{{$finding->description}}</td>
                    <td>{{$finding->status}}</td>
                    <td>{!! link_to('system-admin/accreditation/eop/status/'.$eop->id.'/finding/'.$finding->id,'View',['class' => 'btn-xs btn-warning']) !!}</td>
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
