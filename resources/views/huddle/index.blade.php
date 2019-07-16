@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Huddle Configs for '.session('healthsystem_name'))
@section('page_description','Manage huddle configs here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ul class="nav nav-pills">
  <li class="active"><a data-toggle="pill" href="#configs">Configs</a></li>
  <li><a data-toggle="pill" href="#care-teams">Care Teams</a></li>
</ul>

<div class="tab-content">
  <div id="configs" class="tab-pane fade in active">
        <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Huddle Configs for {{session('healthsystem_name')}}</h3>
        <div class="box-tools pull-right">
          <a href="{{url('system-admin/huddle/configs/create')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add Huddle Config</a>
        </div>
      </div>
      <div class="box-body">
        <table id="config-table" class="table table-striped" type="custom">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Schedule</th>
                        <th>Time</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Schedule</th>
                        <th>Time</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($huddle_configs as $huddle_config)
                    <tr id="tr-config-{{$huddle_config->id}}">
                        <td>{{$huddle_config->careTeam->name}}</td>
                        <td>{{implode('-',$huddle_config->schedule)}}</td>
                        <td>{{$huddle_config->time}}</td>
                        <td>{!! link_to('system-admin/huddle/configs/'.$huddle_config->id.'/edit','Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteHuddleConfig('.$huddle_config->id.')']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>

            {{$huddle_configs->fragment('configs')->links()}}
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>

  </div>

    <div id="care-teams" class="tab-pane fade in">
        <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Care Teams for {{session('healthsystem_name')}}</h3>
        <div class="box-tools pull-right">
          <a href="{{url('system-admin/huddle/care-team/create')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add Care Team</a>
        </div>
      </div>
      <div class="box-body">
        <table id="care-team-table" class="table table-striped" type="custom">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Tier</th>
                        <th>Location</th>
                        <th>Leader</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Tier</th>
                        <th>Location</th>
                        <th>Leader</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($care_teams as $care_team)
                    <tr id="tr-careteam-{{$care_team->id}}">
                        <td>{{$care_team->name}}</td>
                        <td>{{ $care  _team->tier->name }}</td>
                        <td>{{$care_team->location}}</td>
                        <td>{{ $care_team->leader->name }}</td>
                        <td>{!! link_to('system-admin/huddle/care-teams/'.$care_team->id.'/edit','Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteCareTeam('.$care_team->id.')']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>

            {{$care_teams->fragment('care-teams')->links()}}
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>

  </div>

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
                        $('#tr-config-'+id).remove();
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

      function deleteCareTeam(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('system-admin/huddle/care-teams/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'id': id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                        $('#tr-careteam-'+id).remove();
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
