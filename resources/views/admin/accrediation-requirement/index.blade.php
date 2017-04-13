@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Accrediation Requirements')
@section('page_description','Manage accrediation requirements here.')

@section('content')
@include('layouts.partials.success')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Accrediation Requirements</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/accrediation-requirements/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Requirement</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Accrediation Requirement</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Id</th>
                      <th>Accrediation Requirement</th>
                      <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($accrediation_requirements as $accrediation_requirement)
                    <tr>
                      <td>{{$accrediation_requirement->id}}</td>
                      <td>{{$accrediation_requirement->name}}</td>
                      <td><a href="{{url('admin/accrediation-requirements/edit/'.$accrediation_requirement->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>
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
