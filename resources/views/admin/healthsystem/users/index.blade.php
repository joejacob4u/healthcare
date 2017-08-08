@extends('layouts.app')

@section('head')
@parent
@section('page_title','Health Care System Admins')
@section('page_description','Manage Health Care System Admins here.')

@endsection
@section('content')
@include('layouts.partials.success')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">System Admins</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/healthsystem/users/add')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add System Admin</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Phone</th>
                        <th>Health System</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>E-Mail</th>
                      <th>Phone</th>
                      <th>Health System</th>
                      <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->healthSystem->healthcare_system}}</td>
                        <td>{!! link_to('admin/healthsystem/users/edit/'.$user->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
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
