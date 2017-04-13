@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Elements of Performance')
@section('page_description','Add elements of performance here')

@section('content')
@include('layouts.partials.success')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Elements of Performance for {{$standard_label->name}}</h3>

        <div class="box-tools pull-right">
          <a href="{{url('standard-label/'.$standard_label->id.'/eop/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add EOP</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Id</th>
                      <th>Name</th>
                      <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($standard_label->eops as $eop)
                    <tr>
                      <td>{{$eop->id}}</td>
                      <td>{{$eop->name}}</td>
                      <td>{{link_to('admin/standard_label/'.$standard_label->id.'eop/edit/'.$eop->id,'Edit', ['class' => 'btn btn-warning'] )}}</td>
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
