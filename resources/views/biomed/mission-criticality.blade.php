@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Mission Criticality')
@section('page_description','Manage mission criticalities here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Mission Criticality</h3>
        </div>
        <div class="box-body">
            <form class="form-inline" role="form" method="POST" action="/admin/biomed/mission-criticality">
                <div class="form-group">
                    <label for="name">Mission Criticality</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter criticality">
                </div>

                <div class="form-group">
                    <label for="name">Score</label>
                    <input type="text" class="form-control" name="score" id="score" placeholder="Enter score">
                </div>

                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
        <!-- /.box-body -->
      </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Mission Criticality</h3>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Score</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Score</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($mission_criticalities as $mission_criticaly)
                    <tr id="tr-{{$mission_criticaly->id}}">
                        <td>{{$mission_criticaly->name}}</td>
                        <td>{{$mission_criticaly->score}}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteMissionCriticality('.$mission_criticaly->id.')']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>


    <script>

      function deleteMissionCriticality(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/biomed/mission-criticality/delete') }}',
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
