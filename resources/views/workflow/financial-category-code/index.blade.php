@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Financial Category Codes')
@section('page_description','Manage Financial Category Codes here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Financial Category Codes</h3>
        <div class="box-tools pull-right">
          <a href="{{url('workflows/financial-category-codes/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Financial Category Code</a>
        </div>

      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Category Group</th>
                        <th>Category</th>
                        <th>Category Number</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Category Group</th>
                        <th>Category</th>
                        <th>Category Number</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($financial_catergory_codes as $financial_catergory_code)
                    <tr id="tr-{{$financial_catergory_code->id}}">
                        <td>{{$financial_catergory_code->category_group}}</td>
                        <td>{{$financial_catergory_code->category}}</td>
                        <td>{{$financial_catergory_code->category_number}}</td>
                        <td>{!! link_to('workflows/financial-category-codes/edit/'.$financial_catergory_code->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                        <td>{!! link_to('#','Delete',['class' => 'btn-xs btn-danger','onclick' => 'deleteFinancialCategoryCode('.$financial_catergory_code->id.')']) !!}</td>
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

      function deleteFinancialCategoryCode(id)
      {
          bootbox.confirm("Are you sure you want to delete?", function(result)
          { 
             if(result == 1)
             {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('workflows/financial-category-codes/delete') }}',
                    data: { '_token' : '{{ csrf_token() }}', 'financial_catergory_code_id': id},
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
