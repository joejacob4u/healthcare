@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Configure Roundings for '.session('building_name'))
@section('page_description','Manage roundings here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Rounding Configurations for {{session('building_name')}}</h3>
        <div class="box-tools pull-right">
          <a href="{{url('rounding/config/create')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add Rounding Configuration</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Dept</th>
                        <th>Checklist Type</th>
                        <th>Frequency</th>
                        <th>Baseline Date</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Dept</th>
                        <th>Checklist Type</th>
                        <th>Frequency</th>
                        <th>Baseline Date</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($configs as $config)
                    <tr id="tr-{{$config->id}}">
                        <td>{{$config->department->name}}</td>
                        <td>{{$config->checklistType->name}}</td>
                        <td>{{$config->frequency}}</td>
                        <td>{{ $config->baseline_date->toFormattedDateString() }}</td>
                        <td>{!! link_to('rounding/config/'.$config->id.'/edit','Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteRoundingConfig('.$config->id.')']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>

            {{$configs->links()}}
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
