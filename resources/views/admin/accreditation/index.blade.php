@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Accreditation Requirements</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/accreditation/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Requirement</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Department</th>
                        <th>Label</th>
                        <th>Text</th>
                        <th>Created</th>
                        <th>EOP</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Id</th>
                      <th>Department</th>
                      <th>Label</th>
                      <th>Text</th>
                      <th>Created</th>
                      <th>EOP</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($requirements as $requirement)
                    <tr>
                      <td>{{$requirement->id}}</td>
                      <td>{{$requirement->department->name}}</td>
                      <td>{{$requirement->label}}</td>
                      <td>{{$requirement->text}}</td>
                      <td>{{$requirement->created_at}}</td>
                      <td>{{ link_to('admin/accreditation/eop/'.$requirement->id, $title = 'EOP', $attributes = ['class' => 'btn-sm btn-primary'], $secure = null)}}</td>
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
