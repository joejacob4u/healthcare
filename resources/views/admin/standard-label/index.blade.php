@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Standard Labels')
@section('page_description','Manage standard labels here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')
    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>

        </div>
        <div class="box-body">
          {!! Form::open(['url' => 'admin/standard-label/filter', 'class' => 'form-inline']) !!}
          <div class="form-group">
              {!! Form::label('accreditation', 'Accreditation:', ['class' => 'control-label']) !!}
              {!! Form::select('accreditation', $accreditations, $accreditation, ['class' => 'form-control','placeholder' => 'All','id' => 'accreditation']); !!}
          </div>
            <div class="form-group">
                {!! Form::label('accreditation_requirement', 'Accreditation Requirement:', ['class' => 'control-label']) !!}
                {!! Form::select('accreditation_requirement', $accreditation_requirements, $accreditation_requirement, ['class' => 'form-control','id' => 'accreditation_requirement']); !!}
            </div>
            <button type="submit" class="btn btn-default">Filter</button>
          {!! Form::close()  !!}
        </div>
        <!-- /.box-body -->
      </div>


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Standard Labels</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/standard-label/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Standard Label</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Text</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Manage EOP</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Label</th>
                      <th>Text</th>
                      <th>Edit</th>
                      <th>Delete</th>
                      <th>Manage EOP</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($standard_labels as $standard_label)
                    <tr>
                      <td>{{$standard_label->label}}</td>
                      <td>{{$standard_label->text}}</td>
                      <td>{!! link_to('admin/standard-label/edit/'.$standard_label->id,'Edit',['class' => 'btn btn-warning btn-xs']); !!}</td>
                      <td>{!! link_to('admin/standard-label/delete/'.$standard_label->id,'Delete',['class' => 'btn btn-danger btn-xs']); !!}</td>
                      <td>{!! link_to('admin/standard-label/'.$standard_label->id.'/eop','Manage EOP',['class' => 'btn btn-primary btn-xs']); !!}</td>
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

    $( "#accreditation" ).change(function() {
      if($(this).val())
      {
        $.ajax({
          type: 'POST',
          url: '{{ url('admin/standard-label/fetch/accreditation-requirements') }}',
          data: { '_token' : '{{ csrf_token() }}', 'accreditation': $(this).val() },
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            $('#accreditation_requirement').html("");

            var html = '';

            $.each(data, function(index, value) {
              html += '<option value="'+value.id+'">'+value.name+'</option>'
            });

            $('#accreditation_requirement').append(html);
            $('#accreditation_requirement').prop("disabled",false);

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

    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });


    </script>

@endsection
