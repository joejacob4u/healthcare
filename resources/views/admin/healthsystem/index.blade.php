@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Healthcare System</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/healthsystem/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Healthcare System</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Healthcare System</th>
                        <th>State</th>
                        <th>Phone</th>
                        <th>Admin</th>
                        <th>HCO</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Healthcare System</th>
                      <th>State</th>
                      <th>Phone</th>
                      <th>Admin</th>
                      <th>HCO</th>
                      <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($healthsystems as $healthsystem)
                    <tr>
                        <td>{{$healthsystem->healthcare_system}}</td>
                        <td>{{$healthsystem->state}}</td>
                        <td>{{$healthsystem->admin_phone}}</td>
                        <td>{{$healthsystem->admin_email}}</td>
                        <td>{!! link_to('admin/healthsystem/'.$healthsystem->id.'/hco','HCO',['class' => 'btn-xs btn-info']) !!}</td>
                        <td>{!! link_to('admin/healthsystem/edit/'.$healthsystem->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
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
