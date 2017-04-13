@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Accrediations')
@section('page_description','Manage accrediations here.')

@section('content')
@include('layouts.partials.success')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Accreditation</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/accrediation/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Requirement</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Accrediation</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Id</th>
                      <th>Accrediation</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($accrediations as $accrediation)
                    <tr>
                      <td>{{$accrediation->id}}</td>
                      <td>{{$accrediation->name}}</td>
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
