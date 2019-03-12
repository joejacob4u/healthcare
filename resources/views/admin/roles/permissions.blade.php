@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Permissions')
@section('page_description','Manage permissions for <strong>'.$role->name.'</strong>')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="/admin/roles"> Roles</a></li>
    <li class="active">Permissions</li>
</ol>

{!! Form::open(['url' => 'admin/roles/'.$role->id.'/permissions', 'class' => '']) !!}

    <button type="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-ok"></span> Save</button><br><br>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"><mark>{{$role->name}}</mark> in Facility Maintenance has permission to :</h3>
      </div>
      <div class="box-body">
        <div class="row">
            <div class="col-xs-6"><input type="checkbox" name="permissions[]" value="manage.fm-user" @if(in_array('manage.fm-user',$role->permissions)) checked @endif> Manage Facility Maintenance User (Add/Remove)</div>
        </div>

        <div class="row">
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="view.equipment" @if(in_array('view.equipment',$role->permissions)) checked @endif> View Equipment</div>
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="add.equipment" @if(in_array('add.equipment',$role->permissions)) checked @endif> Add Equipment</div>
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="edit.equipment" @if(in_array('edit.equipment',$role->permissions)) checked @endif> Edit Equipment</div>
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="delete.equipment" @if(in_array('delete.equipment',$role->permissions)) checked @endif> Delete Equipment</div>
        </div>
        <div class="row">
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="manage.inventory" @if(in_array('manage.inventory',$role->permissions)) checked @endif> Manage Inventory</div>
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="manage.baselinedate" @if(in_array('manage.baselinedate',$role->permissions)) checked @endif> Manage Baseline Dates</div>
        </div>
        <div class="row">
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="view.pm-workorders" @if(in_array('view.pm-workorders',$role->permissions)) checked @endif> View PM Work Orders</div>
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="complete.pm-workorders" @if(in_array('complete.pm-workorders',$role->permissions)) checked @endif> Complete PM Work Orders</div>
        </div>
        <div class="row">
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="view.dm-workorders" @if(in_array('view.dm-workorders',$role->permissions)) checked @endif> View DM Work Orders</div>
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="addstatus.dm-workorders" @if(in_array('addstatus.dm-workorders',$role->permissions)) checked @endif> Add Status to DM Work Orders</div>
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="complete.dm-workorders" @if(in_array('complete.dm-workorders',$role->permissions)) checked @endif> Complete DM Work Orders</div>
        </div>
        <div class="row">
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="view.equipment" @if(in_array('view.equipment',$role->permissions)) checked @endif> View Equipment</div>
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="add.equipment" @if(in_array('add.equipment',$role->permissions)) checked @endif> Add Equipment</div>
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="edit.equipment" @if(in_array('edit.equipment',$role->permissions)) checked @endif> Edit Equipment</div>
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="delete.equipment" @if(in_array('delete.equipment',$role->permissions)) checked @endif> Delete Equipment</div>
        </div>
        <div class="row">
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="view.ilsm" @if(in_array('view.ilsm',$role->permissions)) checked @endif> View ILSM</div>
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="preassessment.ilsm" @if(in_array('preassessment.ilsm',$role->permissions)) checked @endif> Preassessment ILSM</div>
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="checklist.ilsm" @if(in_array('checklist.ilsm',$role->permissions)) checked @endif> ILSM Checklists</div>
            <div class="col-xs-3"><input type="checkbox" name="permissions[]" value="approve.ilsm" @if(in_array('approve.ilsm',$role->permissions)) checked @endif> Approve ILSM</div>
        </div>
        <div class="row">
            <div class="col-xs-6"><input type="checkbox" name="permissions[]" value="signoff.ilsm" @if(in_array('signoff.ilsm',$role->permissions)) checked @endif> Sign Off ILSM</div>
        </div>






      </div>
      <!-- /.box-body -->
      <div class="box-footer">
      </div>
      <!-- /.box-footer-->
    </div>

    <!-- /Accreditation Permissions -->

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"><mark>{{$role->name}}</mark> in Accreditation has permission to :</h3>
      </div>
      <div class="box-body">
        <center><p>Work in Progress</p></center>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
      </div>
      <!-- /.box-footer-->
    </div>


 {!! Form::close() !!}

@endsection
