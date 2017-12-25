@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in Financial Category Code</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'workflows/financial-category-codes/add', 'class' => 'form-horizontal']) !!}

            <fieldset>


              <div class="form-group">
                  {!! Form::label('category_group', 'Category Group:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('category_group', Request::old('category_group'), ['class' => 'form-control', 'placeholder' => 'category group']) !!}
                  </div>
              </div>

                <div class="form-group">
                    {!! Form::label('category', 'Category:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('category', Request::old('category'), ['class' => 'form-control', 'placeholder' => 'Category']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('category_number', 'Category Number:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('category_number', Request::old('category_number'), ['class' => 'form-control', 'placeholder' => 'Category Number']) !!}
                    </div>
                </div>



                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('workflows/financial-category-codes', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Add Financial Category Code', ['class' => 'btn btn-success pull-right'] ) !!}
                    </div>
                </div>


            </fieldset>

            {!! Form::close()  !!}
               </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer-->
    </div>

@endsection
