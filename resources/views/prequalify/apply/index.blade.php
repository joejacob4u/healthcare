@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Prequalify Application')
@section('page_description','Manage prequalify applications here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">My Proposals</h3>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Health System</th>
                        <th>State</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Health System</th>
                      <th>State</th>
                      <th>Apply</th>
                </tr>
                </tfoot>
                <tbody>
                  @foreach($applications as $application)
                    <tr>
                      <td>{{$application->healthSystem->healthcare_system}}</td>
                      <td>{{$application->healthSystem->state}}</td>
                      @if($application->status == 'pending')
                        <td><span class="label label-warning">pending</span></td>
                      @endif
                      @if($application->status == 'approved')
                        <td><span class="label label-success">approved</span></td>
                      @endif
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



    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Apply for a HealthSystem</h3>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Health System</th>
                        <th>State</th>
                        <th>Apply</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Health System</th>
                      <th>State</th>
                      <th>Apply</th>
                </tr>
                </tfoot>
                <tbody>
                  @foreach($healthsystems as $healthsystem)
                    <tr>
                      <td>{{$healthsystem->healthcare_system}}</td>
                      <td>{{$healthsystem->state}}</td>
                      <td>{!! link_to('contractor/prequalify/apply/'.$healthsystem->id,'Apply',['class' => 'btn-xs btn-primary']) !!}</td>
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
