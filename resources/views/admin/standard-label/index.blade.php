@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Standard Labels')
@section('page_description','Manage standard labels here.')

@section('content')
@include('layouts.partials.success')
    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Filter by Accreditation Requirement</h3>

        </div>
        <div class="box-body">
          {!! Form::open(['url' => 'admin/standard-label/filter', 'class' => 'form-inline']) !!}
            <div class="form-group">
                {!! Form::select('accreditation_requirement', $accreditation_requirements, $accreditation_requirement, ['class' => 'form-control','placeholder' => 'All']); !!}
            </div>
            <button type="submit" class="btn btn-default">Filter</button>
          {!! Form::close()  !!}
        </div>
        <!-- /.box-body -->
      </div>


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Standard Labels</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/standard-label/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Standard Label</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Manage EOP</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Label</th>
                      <th>Edit</th>
                      <th>Delete</th>
                      <th>Manage EOP</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($standard_labels as $standard_label)
                    <tr>
                      <td>{{$standard_label->label}}</td>
                      <td>{!! link_to('admin/standard-label/edit/'.$standard_label->id,'Edit',['class' => 'btn btn-warning btn-xs']); !!}</td>
                      <td>{!! link_to('admin/standard-label/delete/'.$standard_label->id,'Delete',['class' => 'btn btn-danger btn-xs']); !!}</td>
                      <td>{!! link_to('admin/standard-label/'.$standard_label->id.'/eop','Manage EOP',['class' => 'btn btn-primary btn-xs']); !!}</td>
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
