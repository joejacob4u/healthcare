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
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Health System</th>
                        <th>E-Mail</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Role</th>
                      <th>Health System</th>
                      <th>E-Mail</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->role}}</td>
                        <td>{{$user->admin_phone}}</td>
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
