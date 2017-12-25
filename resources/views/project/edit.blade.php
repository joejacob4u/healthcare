@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Project')
@section('page_description','Edit Project Here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit a Project (General Information)</h3>
      </div>
      <div class="box-body">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#general-tab" data-toggle="tab">General</a></li>
        <li><a href="#con-tab" data-toggle="tab">CON</a></li>
        <li><a href="#financial-tab" data-toggle="tab">Financial</a></li>
        <li><a href="#facilities-tab" data-toggle="tab">Facilities</a></li>
        <li><a href="#ranking-question-tab" data-toggle="tab">Ranking Questions</a></li>
        <li><a href="#equipment-tab" data-toggle="tab">Equipment</a></li>
        <li><a href="#accreditation-tab" data-toggle="tab">Accreditation</a></li>
        <li><a href="#leadership-tab" data-toggle="tab">Leadership</a></li>
     </ul>
     
     <div class="tab-content">
        <div class="tab-pane fade in active" id="general-tab">@include('project.partials.general')</div>
        <div class="tab-pane fade" id="con-tab">@include('project.partials.cons')</div>
        <div class="tab-pane fade" id="financial-tab">@include('project.partials.financial')</div>
        <div class="tab-pane fade" id="facilities-tab">@include('project.partials.facilities')</div>
        <div class="tab-pane fade" id="ranking-question-tab">@include('project.partials.questions')</div>
        <div class="tab-pane fade" id="equipment-tab">@include('project.partials.equipment')</div>
        <div class="tab-pane fade" id="accreditation-tab">@include('project.partials.accreditation')</div>
        <div class="tab-pane fade" id="leadership-tab">@include('project.partials.leadership')</div>
    </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>

    <script>

    $( "#hco_id" ).change(function() {
        $.ajax({
          type: "POST",
          url: "{{url('project/fetch/sites')}}",
          data: {'_token' : '{{ csrf_token() }}','hco_id' : $(this).val()},
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            var html = '';

            $.each(data.sites, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+'</option>';
            });

            $('#site_id').html('');
            $('#site_id').prop('disabled',false);
            $('#site_id').append(html);
          },
          error:function()
          {
            // failed request; give feedback to user
          },
          complete: function(data)
          {
              $('.overlay').remove();
          }
        });
    });

    $( "#site_id" ).click(function() {
        $.ajax({
          type: "POST",
          url: "{{url('project/fetch/buildings')}}",
          data: {'_token' : '{{ csrf_token() }}','site_id' : $(this).val()},
          beforeSend:function()
          {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          },
          success:function(data)
          {
            var html = '';
            
            $.each(data.buildings, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+'</option>';
            });

            $('#buildings').html('');
            $('#buildings').prop('disabled',false);
            $('#buildings').append(html);
          },
          error:function()
          {
            // failed request; give feedback to user
          },
          complete: function(data)
          {
              $('#buildings').selectpicker('refresh');
              $('.overlay').remove();
          }
        });
    });

    </script>

@endsection

