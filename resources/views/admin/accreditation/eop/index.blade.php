@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Elements of Performance for {{$accr_requirement->label}}</h3>

    <div class="box-tools pull-right">
      <a href="{{url('admin/accreditation/eop/add/'.$accr_requirement->id)}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add EOP</a>
    </div>
    <div class="box-body">
      <table id="example" class="table table-striped">
              <thead>
                  <tr>
                      <th>EOP #</th>
                      <th>Documentation</th>
                      <th>Risk</th>
                      <th>Frequency</th>
                  </tr>
              </thead>
              <tfoot>
                  <tr>
                    <th>EOP #</th>
                    <th>Documentation</th>
                    <th>Risk</th>
                    <th>Frequency</th>
                  </tr>
              </tfoot>
              <tbody>
                @if($accr_requirement->eops)
                  @foreach($accr_requirement->eops as $eop)
                    <tr>
                      <td>{{$eop->id}}</td>
                      <td>{{$eop->standard_label}}</td>
                      <td>{{$eop->documentation}}</td>
                      <td>{{$eop->risk}}</td>
                      <td>{{$eop->frequency}}</td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
          </table>

    </div>
  </div>
</div>

@endsection
