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
    <li class="active">TJC Standards</li>
</ol>

<div class="callout callout-info">
    <h4>Add Standard Label</h4>
    <p>You will need to add a standard label first to configure additional eops under it.</p>
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Configured Standards</h3> <small>Click to configure</small>

        <div class="box-tools pull-right">
            <button data-toggle="modal" data-target="#standardLabelModal" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add Standard</button>
        </div>
    </div>
    <div class="box-body">
        <ul class="list-group">
            @foreach($tjc_standard_labels as $tjc_standard_label)
                <li id="list_{{$tjc_standard_label->id}}" data-toggle="collapse" data-target="#standard-label-collapse-{{$tjc_standard_label->id}}" class="list-group-item"><strong>{{$tjc_standard_label->standardLabel->label}}</strong><button onclick="removeStandard('{{$tjc_standard_label->id}}')" class="btn btn-danger btn-xs pull-right"><span class="glyphicon glyphicon-trash"></span> Remove Standard</button></li>
                <div id="standard-label-collapse-{{$tjc_standard_label->id}}" class="collapse">
                    <div class="panel panel-default">
                        <div class="panel-heading">Configured EOPs <button onclick="addEOP('{{$tjc_standard_label->standardLabel->id}}','{{$tjc_standard_label->id}}')" class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span> Add EOP</button></div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>EOP Name</th>
                                    <th>Is In Policy</th>
                                    <th>Is Implemented as Required</th>
                                    <th>EOC LS Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tjc_standard_label->tjc_checklist_eops as $checklist_eop)
                                    <tr>
                                        <td>{{$checklist_eop->eop->name}}</td>
                                        <td>{{$checklist_eop->is_in_policy}}</td>
                                        <td>{{$checklist_eop->is_implemented_as_required}}</td>
                                        <td>{{$checklist_eop->eoc_ls_status}}</td>
                                        <td>{!! link_to('#','Edit',['class' => 'btn-xs btn-primary']) !!}{!! link_to('#','Remove',['class' => 'btn-xs btn-danger']) !!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>                
                </div>
            @endforeach
        </ul>
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
                <select class="form-control selectpicker" name="standard_label_id" id="standard_label_id">
                    <option value="0">Please select</option>
                    @foreach($standard_labels as $standard_label)
                        <option value="{{$standard_label->id}}">{{$standard_label->label}}</option>
                    @endforeach
                </select>
                @foreach($standard_labels as $standard_label)
                        <standard id="standard_text_{{$standard_label->id}}" data-text="{{$standard_label->text}}"/>
                @endforeach
            </div>

            <div class="alert alert-info" style="display:none" id="standard_label_text_div">
                <h4><i class="icon fa fa-info"></i> Standard Label Text</h4>
                <p id="standard_label_text"></p>
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

<div id="eopModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Configure EOP</h4>
      </div>
      <div class="modal-body">
        <form action="{{url('tjc_checklist/eops')}}" method="POST">
            {{csrf_field()}}
            <div class="form-group">
                <label for="standards">Select EOP:</label>
                <select class="form-control" name="eop_id" id="eop_id">
                    <option value="0">Please select</option>
                </select>
            </div>

            <div class="form-group">
                <label for="is_in_policy">In Policy ?:</label>
                <select class="form-control selectpicker" name="is_in_policy" id="is_in_policy">
                    <option value="0">Please select</option>
                    <option value="N/A">N/A</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="is_implemented_as_required">In Policy ?:</label>
                <select class="form-control selectpicker" name="is_implemented_as_required" id="is_implemented_as_required">
                    <option value="0">Please select</option>
                    <option value="N/A">N/A</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="eoc_ls_status">EOC LS Status:</label>
                <select class="form-control selectpicker" name="eoc_ls_status" id="eoc_ls_status">
                    <option value="0">Please select</option>
                    <option value="C" data-content="<span class='label label-success'>C</span>">C</option>
                    <option value="NC" data-content="<span class='label label-danger'>NC</span>">NC</option>
                    <option value="N/A" data-content="<span class='label label-default'>N/A</span>">NC</option>
                    <option value="IOU" data-content="<span class='label label-warning'>IOU</span>">IOU</option>
                </select>
            </div>

            <div class="alert alert-info" style="display:none" id="standard_label_text_div">
                <h4><i class="icon fa fa-info"></i> Standard Label Text</h4>
                <p id="standard_label_text"></p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Add EOP</button>
        </div>
        <input type="hidden" id="tjc_checklist_standard_id" name="tjc_checklist_standard_id" value="">
      </form>
      </div>
    </div>

  </div>
</div>

<script>

$('#standard_label_id').change(function(){
    $('#standard_label_text').html($('#standard_text_'+$(this).val()).data('text'));
    $('#standard_label_text_div').show();
})

function addEOP(standard_label_id,tjc_checklist_standard_id)
{
    $.ajax({
        type: 'POST',
        url: '{{ url('tjc_checklist/standards/eops') }}',
        data: { '_token' : '{{ csrf_token() }}','standard_label_id': standard_label_id},
        beforeSend:function()
        {
            
        },
        success:function(data)
        {
            let html = '';

            $.each(data,function(key,value){
                html += `<option value="${value.id}">${value.name}</option>`;
            })

            $('#eop_id').append(html);
            $('#tjc_checklist_standard_id').val(tjc_checklist_standard_id);
            $('#eopModal').modal('show');
            $('#eop_id').selectpicker('render');

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

function removeStandard(tjc_checklist_standard_id)
{
    bootbox.confirm("Are you sure you want to delete? This will delete all standards and eops under it.", function(result)
    { 
        if(result == 1)
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('tjc_checklist/standards/delete') }}',
                data: { '_token' : '{{ csrf_token() }}','tjc_checklist_standard_id': tjc_checklist_standard_id},
                beforeSend:function()
                {
                    
                },
                success:function(data)
                {
                    if(data == 'true')
                    {
                        $('#list_'+tjc_checklist_standard_id).remove();
                        $('#standard-label-collapse-'+tjc_checklist_standard_id).remove();
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