@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Requirement Frequency')
@section('page_description','Manage requirement frequency here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Requirement Frequency</h3>
        </div>
        <div class="box-body">
            <form class="form-inline" role="form" method="POST" action="/admin/maintenance/requirement-frequency">
                <div class="form-group">
                    <label for="name">Utility Function</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter requirement frequency name">
                </div>

                <div class="form-group">
                    <label for="name">Score</label>
                    <input type="text" class="form-control" name="score" id="score" placeholder="score">
                </div>

                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
        <!-- /.box-body -->
      </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Utility Functions</h3>

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
                  @foreach($requirement_frequencies as $requirement_frequency)
                    <tr id="tr-{{$requirement_frequency->id}}">
                        <td>{{$requirement_frequency->name}}</td>
                        <td>{{$requirement_frequency->score}}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteRequirementFrequency('.$requirement_frequency->id.')']) !!}</td>
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

      function deleteRequirementFrequency(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/maintenance/requirement-frequency/delete') }}',
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
