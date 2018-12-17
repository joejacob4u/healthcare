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
        <div class="box-tools pull-right">
          <a data-toggle="modal" data-target="#initiateChecklistModal" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Initiate Checklist</a>
        </div>
    </div>
    <div class="box-body">
        <div class="list-group">
            @foreach($tjc_checklists as $tjc_checklist)
                <a href="#" class="list-group-item" id="li_{{$tjc_checklist->id}}">
                    <h4 class="list-group-item-heading">Created by : <strong>{{App\User::find($tjc_checklist->user_id)->name }}</strong> at <strong>{{ \Carbon\Carbon::parse($tjc_checklist->created_at)->toFormattedDateString() }}</strong> for {{ $tjc_checklist->activity }} <button class="btn btn-danger btn-xs pull-right" onclick="deleteTJCChecklist('{{$tjc_checklist->id}}')"><span class="glyphicon glyphicon-trash"></span> Delete</button><button data-toggle="modal" href="#modal_{{$tjc_checklist->id}}" class="btn btn-warning btn-xs pull-right"><span class="glyphicon glyphicon-info-sign"></span>Surveyor Info</button><button data-toggle="collapse" href="#collapse_{{$tjc_checklist->id}}" class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-th-list"></span> Show List</button></h4>
                    <p id="snapshot-{{$tjc_checklist->id}}" class="list-group-item-text">
                        <strong>Status:</strong>
                        @php $tjc_checklist_progress = $tjc_checklist->tjcChecklistStatusStatusesSnapshot();   @endphp
                        <span class="label label-default not_set">Not Set : {{$tjc_checklist_progress['not_set']}}</span>
                        <span class="label label-primary na">N/A : {{$tjc_checklist_progress['na']}}</span>
                        <span class="label label-success c">Compliant : {{$tjc_checklist_progress['c']}}</span>
                        <span class="label label-warning iou">IOU : {{$tjc_checklist_progress['iou']}}</span>
                        <span class="label label-danger nc">Non-Compliant : {{$tjc_checklist_progress['nc']}}</span>
                    </p>
                </a>
                
                <div id="collapse_{{$tjc_checklist->id}}" class="panel-collapse panel-info collapse">
                    <div class="panel-heading"><strong>EOPs</strong> <small>Below are the eops that should be inspected.</small></div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Accreditation</th>
                                <th>Standard Label</th>
                                <th>EOP#</th>
                                <th>EOP Text</th>
                                <th>Is In Policy</th>
                                <th>Is Implemented as Required</th>
                                <th>EOP Status</th>
                                <th>Status</th>
                                <th>View EOP Doc</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($tjc_checklist->tjcChecklistStatuses as $tjc_checklist_status)
                                <tr>
                                    <td>Hospital</td>
                                    <td>{{ $tjc_checklist_status->tjcChecklistEOP->eop->standardLabel->label }}</td>
                                    <td>{{ $tjc_checklist_status->tjcChecklistEOP->eop->name }}</td>
                                    <td>{{ $tjc_checklist_status->tjcChecklistEOP->eop->text }}</td>
                                    <td>{!! Form::select('is_in_policy', ['n/a' => 'N/A', 'yes' => 'Yes','no' => 'No'], $tjc_checklist_status->is_in_policy,['data-field' => 'is_in_policy','data-tjc_checklist_status_id' => $tjc_checklist_status->id]) !!}</td>
                                    <td>{!! Form::select('is_implemented_as_required', ['n/a' => 'N/A', 'yes' => 'Yes','no' => 'No'], $tjc_checklist_status->is_implemented_as_required,['data-field' => 'is_implemented_as_required','data-tjc_checklist_status_id' => $tjc_checklist_status->id]) !!}</td>
                                    <td>@if(!empty($tjc_checklist_status->tjcChecklistEOP->eop->documentSubmissionDates->last()->status)){!! $tjc_checklist_status->tjcChecklistEOP->eop->documentSubmissionDates->last()->status !!} @else N/A @endif</td>
                                    <td>{!! Form::select('status', ['0'=> 'Please Select','c' => 'C','nc' => 'NC','n/a' => 'N/A', 'iou' => 'IOU'], $tjc_checklist_status->status,['data-field' => 'status','data-tjc_checklist_status_id' => $tjc_checklist_status->id]) !!}</td>   
                                    <td>{!! link_to('system-admin/accreditation/eop/'.$tjc_checklist_status->tjcChecklistEOP->eop->id.'/submission_dates','View',['class' => 'btn-xs btn-info','target' => '_blank']) !!}</td>                             
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                 <!-- Modal -->
                <div class="modal fade" id="modal_{{$tjc_checklist->id}}" role="dialog">
                    <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Checklist Info</h4>
                        </div>
                        <div class="modal-body">
                            <p><strong>Surveyor Name :</strong> {{$tjc_checklist->surveyor_name}}</p>
                            <p><strong>Surveyor E-Mail :</strong> {{$tjc_checklist->surveyor_email}}</p>
                            <p><strong>Surveyor Phone :</strong> {{$tjc_checklist->surveyor_phone}}</p>
                            <p><strong>Surveyor Organization :</strong> {{$tjc_checklist->surveyor_organization}}</p>
                            <p><strong>Activity :</strong> {{$tjc_checklist->activity}}</p>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </div>
                </div>
            @endforeach
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
                <label for="standards">Activity</label>
                <input class="form-control" name="activity" type="text">
            </div>

            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            <input type="hidden" name="building_id" value="{{session('building_id')}}">

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

<!-- Modal -->
<div id="eopInspectionModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Inspect EOP</h4>
      </div>
      <div class="modal-body">
        <form action="{{url('tjc_checklist/status')}}" method="POST">
            {{csrf_field()}}
            <div class="form-group">
                <label for="standards">EOP #</label>
                <select class="form-control" name="tjc_checklist_eop_id">
                <option value="0">Please select</option>
                @foreach($tjc_checklist_eops as $tjc_checklist_eop)
                    <option value="{{$tjc_checklist_eop->id}}">{{$tjc_checklist_eop->eop->name}}</option>
                @endforeach
                </select>
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

           <input type="hidden" name="tjc_checklist_id" id="tjc_checklist_id" value="">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Start EOP Inspection</button>
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

function showInspectionModal(tjc_checklist_id)
{
    $('#tjc_checklist_id').val(tjc_checklist_id);
    $('#eopInspectionModal').modal('show');

}

$( "select" ).change(function() {
    
    var field = $(this).data('field');

    $.ajax({
        type: 'POST',
        url: '{{ asset('tjc_checklist/status/update') }}',
        data: { '_token' : '{{ csrf_token() }}', 'tjc_checklist_status_id': $(this).data('tjc_checklist_status_id'),'value': $(this).val(),'field': $(this).data('field')},
        beforeSend:function()
        {
            dialog = bootbox.dialog({
                message: '<p class="text-center">Saving your changes...</p>',
                closeButton: false
            });
        },
        success:function(data)
        {
            if(data.status == 'success')
            {
                dialog.modal('hide');
                
                $.each( data.snapshot, function( key, value ) {
                    
                    if(key == 'not_set'){
                        $('#snapshot-'+data.tjc_checklist_id+' .'+key).html('Not Set : ' +value);
                    }
                    if(key == 'na'){
                        $('#snapshot-'+data.tjc_checklist_id+' .'+key).html('N/A : ' +value);
                    }
                    if(key == 'c'){
                        $('#snapshot-'+data.tjc_checklist_id+' .'+key).html('Compliant : ' +value);
                    }
                    if(key == 'nc'){
                        $('#snapshot-'+data.tjc_checklist_id+' .'+key).html('Non-Compliant : ' +value);
                    }
                    if(key == 'iou'){
                        $('#snapshot-'+data.tjc_checklist_id+' .'+key).html('IOU : ' +value);
                    }

                });
            }
        },
        error:function()
        {
        // failed request; give feedback to user
        },
        complete: function(data)
        {
            $('.overlay').remove();
        }
    });
  
});

function update_status_view(tjc_checklist_id)
{

}

function deleteTJCChecklist(tjc_checklist_id)
{
    bootbox.confirm("Are you sure you want to remove this checklist? This will remove all items associated with checklist.", function(result)
    { 
        if(result == 1)
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('tjc_checklist/delete') }}',
                data: { '_token' : '{{ csrf_token() }}','tjc_checklist_id': tjc_checklist_id},
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    if(data == 'true')
                    {
                        $('#li_'+tjc_checklist_id).remove();
                    }

                },
                error:function(data)
                {

                },
                complete: function(data)
                {
                    $('.overlay').remove();
                }
            });
        }
    });
}


</script>

@endsection