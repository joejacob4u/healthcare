@extends('layouts.app')

@section('head')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 

@endsection
@section('page_title','TJC Checklist')
@section('page_description','Configure TJC Checklist here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">TJC EOPS</li>
</ol>

<div class="callout callout-info">
    <h4>Add EOP</h4>
    <p>To add a EOP to the TJC Checklist you will need to add EOP from the available EOPs, after adding EOPs added to the checklist will appear in the <strong>Added to Checklist</strong>.</p>
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Configured EOP</h3> 
    </div>
    <div class="box-body">
        <ul class="nav nav-tabs">
            <li class="active"><a id="li_added_to_checklist" data-toggle="tab" href="#added_to_checklist">EOPs Added to Checklist</a></li>
            <li><a id="li_not_added_to_checklist" data-toggle="tab" href="#not_added_to_checklist">Available EOPs</a></li>
        </ul>

        <div class="tab-content">
            <div id="added_to_checklist" class="tab-pane fade in active">
                <table id="added_to_checklist_table" class="table table-bordered" type="yajra" style="width:100%">
                    <thead>
                        <tr>
                            <th>EOP Name</th>
                            <th>EOP Text</th>
                            <th>Standard Label</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div id="not_added_to_checklist" class="tab-pane fade">
                <table id="not_added_to_checklist_table" class="table table-bordered" type="yajra" style="width:100%">
                    <thead>
                        <tr>
                            <th>EOP Name</th>
                            <th>EOP Text</th>
                            <th>Standard Label</th>
                            <th>Add</th>
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
<div id="standardLabelModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Standard Label</h4>
      </div>
      <div class="modal-body">
        <form action="{{url('tjc_checklist/standards')}}" method="POST">
            {{csrf_field()}}
            <div class="form-group">
                <label for="standards">Select Standard:</label>
                <input class="typeahead form-control"  type="text">
                
            </div>

            <div class="alert alert-info" style="display:none" id="standard_label_text_div">
                <h4><i class="icon fa fa-info"></i> Standard Label Text</h4>
                <p id="standard_label_text"></p>
            </div>

            <div class="form-group">
                <label for="standards">Select EOP:</label>
                <select class="form-control selectpicker" name="eop_id" id="eop_id">
                    <option value="0">Please select</option>
                </select>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Add Standard</button>
      </div>
      <input type="hidden" name="healthsystem_id" value="{{Auth::user()->healthsystem_id}}">
      </form>
    </div>

  </div>
</div>

<!-- End Modal-->



<script>

 $('#added_to_checklist_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{url('tjc_checklist/added/eops')}}',
        columns: [
            {data: 'eop_name', name: 'eop.name'},
            {data: 'eop_text', name: 'eop.text'},
            {data: 'standard_label', name: 'standard_label.label'},
            {data: 'remove_eop', name: 'remove_eop',searchable: false},
        ],
        initComplete: function(settings, json) {
            $('[data-toggle="popover"]').popover();
        },
        fnDrawCallback: function(settings, json) {
            $('[data-toggle="popover"]').popover();
        },
    });

    $('#not_added_to_checklist_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{url('tjc_checklist/available/eops')}}',
        columns: [
            {data: 'eop_name', name: 'eop.name'},
            {data: 'eop_text', name: 'eop.text'},
            {data: 'standard_label', name: 'standard_label.label'},
            {data: 'add_eop', name: 'add_eop',searchable: false},
        ],
        initComplete: function(settings, json) {
            $('[data-toggle="popover"]').popover();
        },
        fnDrawCallback: function(settings, json) {
            $('[data-toggle="popover"]').popover();
        },
    });


function removeFromChecklist(tjc_checklist_id)
{
    bootbox.confirm("Are you sure you want to remove this EOP from the checklist? This will remove all user data and logs asociated with this EOP.", function(result)
    { 
        if(result == 1)
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('tjc_checklist/eop/delete') }}',
                data: { '_token' : '{{ csrf_token() }}','tjc_checklist_id': tjc_checklist_id},
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    if(data == 'true')
                    {
                        $('#'+tjc_checklist_id).remove();
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

function addToChecklist(eop_id)
{
    bootbox.confirm("Are you sure you want to add this EOP to the checklist? ", function(result)
    { 
        if(result == 1)
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('tjc_checklist/eop/create') }}',
                data: { '_token' : '{{ csrf_token() }}','eop_id': eop_id},
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    if(data == 'true')
                    {
                        $('#'+eop_id).remove();
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

$('#li_added_to_checklist').on('shown.bs.tab', function (e) {
  $('#added_to_checklist_table').DataTable().ajax.reload();
});

$('#li_not_added_to_checklist').on('shown.bs.tab', function (e) {
  $('#not_added_to_checklist_table').DataTable().ajax.reload();
});

$(document).ready(function(){
    $('[data-toggle="popover"]').popover(); 
});


</script>

@endsection