@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Sub-COP for {{$cop->label}}</h3>

        <div class="box-tools pull-right">

          <a href="{{url('admin/cop/'.$cop->id.'/subcop/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add SubCOP</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Section Label</th>
                        <th>Section Text</th>
                        <th>Description</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Section Label</th>
                      <th>Section Text</th>
                      <th>Description</th>
                      <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($cop->subCOPs as $sub_cop)
                    <tr>
                        <td>{{$sub_cop->label}}</td>
                        <td>{{$sub_cop->title}}</td>
                        <td>{{$sub_cop->description}}</td>
                        <td><a href="{{url('admin/cop/'.$cop->id.'/subcop/edit/'.$sub_cop->id)}}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <div class="box-tools pull-right">
          <a href="{{url('admin/cop/')}}" type="button" class="btn btn-block btn-info">Back to COP</a>
        </div>

      </div>
      <!-- /.box-footer-->
    </div>

@endsection
