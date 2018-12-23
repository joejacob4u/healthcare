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
    <li><a href="{{url('admin/equipment/categories')}}">Categories</a></li>
    <li>Maintenance Asset Category for {{$category->name}}</li>
</ol>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Maintenance Asset Categories for {{$category->name}}</h3>
        <div class="box-tools pull-right">
          <a href="{{url('admin/equipment/categories/'.$category->id.'/asset-categories/add')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add Maintenance Asset Categoryr</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>System Tier</th>
                        <th>Service Life</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>System Tier</th>
                        <th>Service Life</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($category->assetCategories as $asset_category)
                    <tr id="tr-{{$asset_category->id}}">
                        <td>{{$asset_category->name}}</td>
                        <td>{{$asset_category->systemTier->name}}</td>
                        <td>{{$asset_category->service_life}}</td>
                        <td>{!! link_to('admin/equipment/categories/'.$category->id.'/asset-categories/edit/'.$asset_category->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
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

    <!-- Modal -->
  <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Asset Categories</h4>
        </div>
        <div class="modal-body">
            <form class="form" role="form" method="POST" action="/admin/equipment/categories/{{$category->id}}/asset-categories/edit">
                <div class="form-group">
                    <label for="name">Maintenance Asset Category</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter category">
                </div>
                <div class="form-group">
                    <label for="name">Required By</label>
                    <select class="form-control" id="required_by" name="required_by">
                        <option value="0">Please select</option>
                        <option value="evs">EVS</option>
                        <option value="biomed">Bio-Med</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="it">Information Technology</option>
                        <option value="grounds_maintenance">Grounds Maintenance</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Service Life</label>
                    <input type="text" class="form-control" name="service_life" id="service_life" placeholder="months">
                </div>

                <input type="hidden" name="asset_category_id" id="asset_category_id" value="">
                <input type="hidden" name="maintenance_category_id" id="maintenance_category_id" value="{{$category->id}}">

                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


    <script>

    function editAssetCategory(id,name,required_by,service_life)
    {
        $('#editModal #name').val(name);
        $('#editModal #required_by').val(required_by);
        $('#editModal #service_life').val(service_life);
        $('#editModal #asset_category_id').val(id);
        $('#editModal').modal('show');
    }

      function deleteAssetCategory(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('admin/equipment/categories/asset-categories/delete') }}',
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
