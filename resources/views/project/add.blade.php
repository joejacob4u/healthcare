@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Project')
@section('page_description','Add a Project Here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add a Project (General Information)</h3>
      </div>
      <div class="box-body">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#general-tab" data-toggle="tab">General</a></li>
        <li class="disabled"><a href="#con-tab" data-toggle="tab">CON</a></li>
        <li><a href="#">Financial</a></li>
        <li><a href="#">Accreditation</a></li>
        <li><a href="#">Leadership</a></li>
        <li><a href="#">Administrative</a></li>
     </ul>
     
     <div class="tab-content">
        <div class="tab-pane fade in active" id="general-tab">@include('project.partials.general')</div>
        <div class="tab-pane fade" id="con-tab">@include('project.partials.con')</div>
        <div class="tab-pane fade" id="C">Content inside tab C</div>
    </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>


@endsection

