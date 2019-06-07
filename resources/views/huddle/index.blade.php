@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Huddle Configs for '.session('healthsystem_name'))
@section('page_description','Manage huddle configs here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Huddle Configs for {{session('healthsystem_name')}}</h3>
        <div class="box-tools pull-right">
          <a href="{{url('system-admin/huddle/configs/create')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add Huddle Config</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped" type="custom">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>HCO</th>
                        <th>Site</th>
                        <th>Building</th>
                        <th>Department</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>HCO</th>
                        <th>Site</th>
                        <th>Building</th>
                        <th>Department</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($huddle_configs as $huddle_config)
                    <tr id="tr-{{$huddle_config->id}}">
                        <td>{{$huddle_config->name}}</td>
                        <td>{{$huddle_config->hco->facility_name}}</td>
                        <td>{{$huddle_config->site->name}} ({{$huddle_config->site->site_id}})</td>
                        <td>{{$huddle_config->building->name}} ({{$huddle_config->building->building_id}})</td>
                        <td>{{ $huddle_config->department->name }}</td>
                        <td>{!! link_to('system-admin/huddle/configs/'.$huddle_config->id.'/edit','Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteHuddleConfig('.$huddle_config->id.')']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>

            {{$huddle_configs->links()}}
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>



    <script>


      function deleteHuddleConfig(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('system-admin/huddle/configs/delete') }}',
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
