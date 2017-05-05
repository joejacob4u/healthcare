@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Elements of Performance')
@section('page_description','Add elements of performance here')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Elements of Performance for {{$standard_label->label}}</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/standard-label/'.$standard_label->id.'/eop/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add EOP</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>EOP #</th>
                        <th>Text</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>EOP #</th>
                      <th>Text</th>
                      <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($standard_label->eops as $eop)
                    <tr>
                      <td>{{$eop->name}}</td>
                      <td>{{link_to('#', 'Text',['class' => 'btn-xs btn-info','data-toggle' => 'popover', 'title' => 'Text Preview','data-content' => $eop->text] )}}</td>
                      <td>{{link_to('admin/standard-label/'.$standard_label->id.'/eop/edit/'.$eop->id,'Edit', ['class' => 'btn-xs btn-warning'] )}}</td>
                      <td>{{link_to('admin/standard-label/'.$standard_label->id.'/eop/delete/'.$eop->id,'Delete', ['class' => 'btn-xs btn-danger'] )}}</td>
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

  <script>
  $(document).ready(function(){
      $('[data-toggle="popover"]').popover();
  });
  </script>

@endsection
