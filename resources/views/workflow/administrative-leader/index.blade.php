@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Administrative Leaders')
@section('page_description','Manage Administrative Leaders.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Administrative Leaders</h3>
        <div class="box-tools pull-right">
          <a href="{{url('workflows/administrative-leaders/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Administrative Leaders</a>
        </div>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($administrative_leaders as $administrative_leader)
                    <tr id="tr-{{$administrative_leader->id}}">
                        <td>{{$administrative_leader->name}}</td>
                        <td>{{$administrative_leader->title}}</td>
                        <td>{{$administrative_leader->email}}</td>
                        <td>{{$administrative_leader->phone}}</td>
                        <td>{!! link_to('workflows/administrative-leaders/edit/'.$administrative_leader->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteAdministrativeLeader('.$administrative_leader->id.')']) !!}</td>
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

      function deleteAdministrativeLeader(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('workflows/administrative-leaders/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'administrative_leader_id': id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                        $('#tr-'+data).remove();
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
