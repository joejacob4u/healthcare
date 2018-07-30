@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Maintenance Asset Category for '.$category->name)
@section('page_description','Manage maintenance asset category here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="{{url('admin/maintenance/categories')}}">Categories</a></li>
    <li>Maintenance Asset Category for {{$category->name}}</li>
</ol>

    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Maintenance Asset Category for {{$category->name}}</h3>
        </div>
        <div class="box-body">
            <form class="form-inline" role="form" method="POST" action="/admin/maintenance/categories/{{$category->id}}/asset-categories">
                <div class="form-group">
                    <label for="name">Maintenance Asset Category</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter category">
                </div>
                <div class="form-group">
                    <label for="name">Service Life</label>
                    <input type="text" class="form-control" name="service_life" id="service_life" placeholder="months">
                </div>

                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
        <!-- /.box-body -->
      </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Maintenance Asset Categories for {{$category->name}}</h3>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Service Life</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Service Life</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($category->assetCategories as $asset_category)
                    <tr id="tr-{{$asset_category->id}}">
                        <td>{{$asset_category->name}}</td>
                        <td>{{$asset_category->service_life}}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteAssetCategory('.$asset_category->id.')']) !!}</td>
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

      function deleteAssetCategory(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/maintenance/asset-categories/delete') }}',
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
