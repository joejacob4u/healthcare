@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in Approval Level Leader</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'workflows/approval-level-leaders/add', 'class' => 'form-horizontal']) !!}

            <fieldset>


              <div class="form-group">
                  {!! Form::label('name', 'Leader Title:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('title', Request::old('title'), ['class' => 'form-control', 'placeholder' => 'title']) !!}
                  </div>
              </div>

                <div class="form-group">
                    {!! Form::label('signing_level_amount', 'Signing level amount:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('signing_level_amount', Request::old('signing_level_amount'), ['class' => 'form-control', 'placeholder' => 'Signing level amount']) !!}
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('workflows/approval-level-leaders', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Add Approval Level Leader', ['class' => 'btn btn-success pull-right'] ) !!}
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
