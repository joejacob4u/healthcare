@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Accrediations')
@section('page_description','Manage accrediations here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

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
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Id</th>
                      <th>Accrediation</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($accrediations as $accrediation)
                    <tr>
                      <td>{{$accrediation->id}}</td>
                      <td>{{$accrediation->name}}</td>
                      <td>{!! link_to('admin/accrediation/edit/'.$accrediation->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                      <td>{!! link_to('admin/accrediation/delete/'.$accrediation->id,'Delete',['class' => 'btn-xs btn-danger']) !!}</td>
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
