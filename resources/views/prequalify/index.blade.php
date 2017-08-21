@extends('layouts.app')

@section('head')
@parent
@section('page_title','Health System Prequalify Form')
@section('page_description','Health System Prequalify Forms here.')

@endsection
@section('content')
@include('layouts.partials.success')
<div class="box box-solid box-primary">
<div class="box-header with-border">
  <h3 class="box-title">User Reference Files</h3>

  <div class="box-tools pull-right">
      <button class="btn btn-warning" onclick="configure()" type="button"><span class="glyphicon glyphicon-pencil"></span> Configure</button>
  </div>
</div>

<div class="box-body" id="user_reference">
    @foreach($prequalify_configs->where('input_type','file')->where('action_type','output') as $file)
    <div class="box box-solid box-success">
            <div class="box-header with-border">
              <h3 class="box-title">File</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" rows="3" placeholder="Enter ..." disabled>{{$file->description}} </textarea>
                </div>
              <div class="form-group">
                  <label>File</label>
                  <input type="text" class="form-control" value="{{$file->value}}" placeholder="" disabled="">
                </div>
              <div class="form-group">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" @if($file->is_required) checked @endif disabled> Required
                      </label>
                    </div>
                  </div>
            </div>
            <!-- /.box-body -->
          </div>
    @endforeach
</div>
<!-- /.box-body -->
<div class="box-footer">

</div>
<!-- /.box-footer-->
</div>

<div class="box box-solid box-warning">
<div class="box-header with-border">
  <h3 class="box-title">Required User Files</h3>

</div>
<div class="box-body" id="user_requirement">
  @foreach($prequalify_configs->where('input_type','file')->where('action_type','input') as $file)
    <div class="box box-solid box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">File Requirement</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" rows="3" placeholder="Enter ..." disabled>{{$file->description}}</textarea>
                </div>
              <div class="form-group">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" @if($file->is_required) checked @endif disabled> Required
                      </label>
                    </div>
                  </div>
            </div>
            <!-- /.box-body -->
          </div>
    @endforeach
</div>
<!-- /.box-body -->
<div class="box-footer">

</div>
<!-- /.box-footer-->
</div>

<div class="box box-solid box-warning">
<div class="box-header with-border">
  <h3 class="box-title">E-Mail Delivery</h3>

</div>
<div class="box-body" id="user_requirement">
  @foreach($prequalify_configs->where('input_type','email')->where('action_type','system') as $email)
    <div class="box box-solid box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">E-Mail</h3>
            </div>
            <div class="box-body">
              <div class="form-group col-xs-8">
                <label for="comment">E-Mail Address:</label>
                <input class="form-control" type="email" value="{{$email->value}}" disabled></input>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
    @endforeach
</div>
<!-- /.box-body -->
<div class="box-footer">

</div>
<!-- /.box-footer-->
</div>


<div class="box box-solid box-info">
<div class="box-header with-border">
  <h3 class="box-title">Acknowledgement</h3>
</div>
<div class="box-body">
@foreach($prequalify_configs->where('input_type','textarea') as $acknowledgement)
  <div class="form-group">
      {!! Form::label('acknowledgement_statement', 'Acknowledgement Statement', ['class' => 'col-lg-2 control-label']) !!}
      <div class="col-lg-10">
          {!! Form::textarea('acknowledgement_statement',$acknowledgement->value,['class' => 'form-control','id' => 'acknowledgement_statement','disabled' => true]); !!}
      </div>
  </div>
  <div class="checkbox col-lg-10">
      <label><input type="checkbox" id="acknowledgement_statement_acknowledge" value="" @if($acknowledgement->is_required) checked @endif disabled>Prompt the User to Acknowledge</label>
  </div>
  @endforeach
</div>
<!-- /.box-body -->
<div class="box-footer">

</div>
<!-- /.box-footer-->
</div>

<div class="box box-solid box-info">
<div class="box-header with-border">
  <h3 class="box-title">Acknowledgement</h3>
</div>
<div class="box-body">
@foreach($prequalify_configs->where('input_type','file')->where('action_type','email') as $welcome_email)
  <div class="form-group">
      {!! Form::label('welcome_email', 'Welcome E-Mail Message', ['class' => 'col-lg-2 control-label']) !!}
      <div class="col-lg-10">
          {!! Form::textarea('welcome_email',$welcome_email->value,['class' => 'form-control','id' => 'welcome_email','disabled' => true]); !!}
      </div>
  </div>
  @endforeach
</div>
<!-- /.box-body -->
<div class="box-footer">

</div>
<!-- /.box-footer-->
</div>

<div class="box box-solid box-primary">
<div class="box-header with-border">
  <h3 class="box-title">Welcome E-Mail Files</h3>

  <div class="box-tools pull-right">
  </div>
</div>

<div class="box-body" id="user_reference">
    @foreach($prequalify_configs->where('input_type','textarea')->where('action_type','email') as $file)
    <div class="box box-solid box-success">
            <div class="box-header with-border">
              <h3 class="box-title">File</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                  <label>Welcome File</label>
                  <input type="text" class="form-control" value="{{$file->value}}" placeholder="" disabled="">
                </div>
            </div>
            <!-- /.box-body -->
          </div>
    @endforeach
</div>
<!-- /.box-body -->
<div class="box-footer">

</div>
<!-- /.box-footer-->
</div>



<script>
function configure()
{
  bootbox.confirm("To configure, you will loose all current configuration and start from scratch. Continue?", function(result){
      if(result)
      {
        window.location = "{{url('prequalify/configure')}}";
      }
    });
}
</script>


@endsection
