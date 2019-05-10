@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Assessments for '.session('building_name'))
@section('page_description','Manage assessments here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Assessments for {{session('building_name')}}</h3>
        <div class="box-tools pull-right">
          <a href="{{url('assessment/create')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add Assessment</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Dept</th>
                        <th>Assessment Section</th>
                        <th>Checklist Type</th>
                        <th>Date</th>
                        <th>User</th>
                        <th>Evaluate</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Dept</th>
                        <th>Assessment Section</th>
                        <th>Checklist Type</th>
                        <th>Date</th>
                        <th>User</th>
                        <th>Evaluate</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($assessments as $assessment)
                    <tr id="tr-{{$assessment->id}}">
                        <td>{{$assessment->department->name}}</td>
                        <td>{{$assessment->section->name}}</td>
                        <td>{{$assessment->checklistType->name}}</td>
                        <td>{{ $assessment->created_at->toDayDateTimeString() }}</td>
                        <td>{{ $assessment->user->name }}</td>
                        <td>{!! link_to('assessment/evaluate/'.$assessment->id,'Evaluate',['class' => 'btn-xs btn-info']) !!}</td>
                        <td>{!! link_to('rounding/config/'.$assessment->id.'/edit','Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteRoundingConfig('.$assessment->id.')']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>

            {{$assessments->links()}}
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>



    <script>


      function deleteRoundingConfig(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('rounding/config/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'id': id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                        $('#tr-'+id).remove();
                    },
                    complete:function()
                    {
                        $('.overlay').remove();
                    },
                    error:function()
                    {
                        // failed request; give feedback to user
                    }
                });
             } 
          });

      }

    </script>

@endsection
