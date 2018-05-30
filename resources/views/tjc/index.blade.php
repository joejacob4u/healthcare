@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','TJC Checklist')
@section('page_description','Configure TJC Checklist here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">TJC Checklist</li>
</ol>

<div class="callout callout-info">
    <h4>TJC Checklists</h4>
    <p>To initiate a TJC Checklist, start from the available TJC Checklists below, your TJC Checklists will appear in "My TJC Checklists"</p>
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">TJC Checklists</h3> 
    </div>
    <div class="box-body">
        <ul class="nav nav-tabs">
            <li class="active"><a id="li_my_tjc_checklists" data-toggle="tab" href="#my_tjc_checklists">My TJC Checklists</a></li>
            <li><a id="li_my_available_tjc_checklists" data-toggle="tab" href="#my_available_tjc_checklists">Available TJC Checklists</a></li>
        </ul>

        <div class="tab-content">
            <div id="my_tjc_checklists" class="tab-pane fade in active">
                <table id="my_tjc_checklists_table" class="table table-bordered" type="yajra" style="width:100%">
                    <thead>
                        <tr>
                            <th>EOP Text</th>
                            <th>Surveyor Name</th>
                            <th>Surveyor E-Mail</th>
                            <th>Surveyor Phone</th>
                            <th>Surveyor Organization</th>
                            <th>In Policy</th>
                            <th>Implemented as Required</th>
                            <th>EOC LS Status</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div id="my_available_tjc_checklists" class="tab-pane fade">
                <table id="my_available_tjc_checklists_table" class="table table-bordered" type="yajra" style="width:100%">
                    <thead>
                        <tr>
                            <th>EOP #</th>
                            <th>EOP Text</th>
                            <th>Standard Label</th>
                            <th>Initiate TJC Checklist</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        Showing current configured standards
    </div>
</div>

<!-- Modal -->
<div id="initiateChecklistModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Initiate TJC Checklist</h4>
      </div>
      <div class="modal-body">
        <form action="{{url('tjc_checklist')}}" method="POST">
            {{csrf_field()}}
            <div class="form-group">
                <label for="standards">Surveyor Name</label>
                <input class="form-control" name="surveyor_name" type="text">
            </div>

            <div class="form-group">
                <label for="standards">Surveyor E-Mail</label>
                <input class="form-control" name="surveyor_email" type="email">
            </div>

            <div class="form-group">
                <label for="standards">Surveyor Phone</label>
                <input class="form-control" name="surveyor_phone" type="text">
            </div>

            <div class="form-group">
                <label for="standards">Surveyor Organization</label>
                <input class="form-control" name="surveyor_organization" type="text">
            </div>

            <div class="form-group">
                <label for="standards">Is In Policy</label>
                <select class="form-control" name="is_in_policy">
                    <option value="0">Please select</option>
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                    <option value="n/a">N/A</option>
                </select>
            </div>

            <div class="form-group">
                <label for="standards">Is Implemented as Required</label>
                <select class="form-control" name="is_implemented_as_required">
                    <option value="0">Please select</option>
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                    <option value="n/a">N/A</option>
                </select>
            </div>

            <div class="form-group">
               <label for="eoc_ls_status">EOC LS Status:</label>
               <select class="form-control selectpicker" name="eoc_ls_status" id="eoc_ls_status">
                   <option value="0">Please select</option>
                   <option value="c" data-content="<span class='label label-success'>C</span>">C</option>
                   <option value="nc" data-content="<span class='label label-danger'>NC</span>">NC</option>
                   <option value="n/a" data-content="<span class='label label-default'>N/A</span>">NC</option>
                    <option value="iou" data-content="<span class='label label-warning'>IOU</span>">IOU</option>
               </select>
           </div>
                  <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="tjc_checklist_eop_id" id="tjc_checklist_eop_id" value="">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Add to My TJC Checklist</button>
      </div>
      </form>
    </div>

  </div>
</div>

<!-- End Modal-->


<script>

$('#my_available_tjc_checklists_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{url('tjc_checklist/available')}}',
    columns: [
        {data: 'eop_name', name: 'eop.name'},
        {data: 'eop_text', name: 'eop.text'},
        {data: 'standard_label', name: 'standard_label.label'},
        {data: 'initiate_checklist', name: 'initiate_checklist',searchable: false},
    ],
    initComplete: function(settings, json) {
        $('[data-toggle="popover"]').popover();
    },
    fnDrawCallback: function(settings, json) {
        $('[data-toggle="popover"]').popover();
    },
});

$('#my_tjc_checklists_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{url('tjc_checklist/added')}}',
    columns: [
        {data: 'eop_text', name: 'eop.text'},
        {data: 'surveyor_name', name: 'tjc_checklists.surveyor_name'},
        {data: 'surveyor_email', name: 'tjc_checklists.surveyor_email'},
        {data: 'surveyor_phone', name: 'tjc_checklists.surveyor_phone'},
        {data: 'surveyor_organization', name: 'tjc_checklists.surveyor_organization'},
        {data: 'is_in_policy', name: 'tjc_checklists.is_in_policy'},
        {data: 'is_implemented_as_required', name: 'tjc_checklists.is_implemented_as_required'},
        {data: 'eoc_ls_status', name: 'tjc_checklists.eoc_ls_status'},
        {data: 'edit_checklist', name: 'edit_checklist',searchable: false},
    ],
    initComplete: function(settings, json) {
        $('[data-toggle="popover"]').popover();
    },
    fnDrawCallback: function(settings, json) {
        $('[data-toggle="popover"]').popover();
    },
});


function initiateChecklist(tjc_checklist_eop_id)
{
    $('#tjc_checklist_eop_id').val(tjc_checklist_eop_id);
    $('#initiateChecklistModal').modal('show');
}


</script>

@endsection