@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Prospects</h3>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Details</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Details</th>
                      <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($prequalify_users as $prequalify_user)
                    <tr>
                        <td>{{$prequalify_user->user->name}}</td>
                        <td>{{$prequalify_user->user->email}}</td>
                        <td>{{$prequalify_user->user->phone}}</td>
                        <td>{!! link_to('users/prospects/details/'.$prequalify_user->id,'Download Files',['class' => 'btn-xs btn-info']) !!}</td>
                        <td>{{$prequalify_user->status}}</td>
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
