@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">CMS COP</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/cop/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add CMS COP</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Section Label</th>
                        <th>Section Text</th>
                        <th>Edit</th>
                        <th>Sub COP</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Section Label</th>
                      <th>Section Text</th>
                      <th>Edit</th>
                      <th>Sub COP</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($cops as $cop)
                    <tr>
                        <td>{{$cop->label}}</td>
                        <td>{{$cop->title}}</td>
                        <td><a href="{{url('admin/cop/edit/'.$cop->id)}}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>
                        <td><a href="{{url('admin/cop/'.$cop->id.'/subcop')}}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-list-alt"></span> Sub COP</a></td>
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
