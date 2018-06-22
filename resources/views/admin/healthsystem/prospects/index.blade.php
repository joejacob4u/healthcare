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
                        <th>Title</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Title</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Details</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($prospect_users as $prospect_user)
                    <tr>
                        <td>{{$prospect_user->user->name}}</td>
                        <td>{{$prospect_user->title}}</td>
                        <td>{{$prospect_user->user->email}}</td>
                        <td>{{$prospect_user->user->phone}}</td>
                        <td>{!! link_to('healthsystem/prospects/details/'.$prospect_user->id,'Details',['class' => 'btn-xs btn-info']) !!}</td>
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
