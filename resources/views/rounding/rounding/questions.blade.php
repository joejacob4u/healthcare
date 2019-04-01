@extends('layouts.app')

@section('head')
@parent
<script src="{{ asset ("/bower_components/moment/moment.js") }}" type="text/javascript"></script>
@endsection
@section('page_title','Rounding Evaluation Questions for '.$rounding->date->toDayDateTimeString())
@section('page_description','Manage roundings here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')


<ol class="breadcrumb">
    <li><a href="{{url('roundings')}}">Roundings</a></li>
    <li>Rounding Questions</li>
</ol>

<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Rounding Leader</span>
              <span class="info-box-number">{{$rounding->config->user->name}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-list-ol"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Checklist</span>
              <span class="info-box-number">{{$rounding->config->checklistType->name}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-refresh"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Frequency</span>
              <span class="info-box-number">{{$rounding->config->frequency}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-university"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Department</span>
              <span class="info-box-number">{{$rounding->config->department->name}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>

{!! Form::open(['url' => 'rounding/'.$rounding->id.'/questions', 'class' => '']) !!}

    <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
            {!! Form::submit('Submit Answers', ['class' => 'btn btn-success pull-right'] ) !!}
        </div>
    </div><br>


@foreach($rounding->config->checklistType->categories as $category)
    
    <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title text-primary"><strong>{{$category->name}}</strong></h3>
          </div>
          <div class="box-body">
            @foreach($category->questions as $question)
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                                {!! Form::label('question_'.$question->id, $question->question, ['class' => '']) !!}
                        </h3>              <!-- /.user-block -->
                        <div class="box-tools">
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {!! Form::select('answers['.$question->id.'][answer]', ['' => 'Please Select'] + $question->answers['answers'], Request::old('answers['.$question->id.'][answer]'), ['class' => 'form-control answer','id' => 'question_'.$question->id,'data-negative' => $question->answers['negative'],'data-question-id' => $question->id]) !!}
                        <span class="pull-right text-muted">{{$rounding->findings->where('question_id',$question->id)->count()}} findings</span>
                    </div>
                    <!-- /.box-body -->
                    <div id="box-footer-{{$question->id}}" class="box-footer box-comments">
                        
                        @foreach($rounding->findings->where('question_id',$question->id) as $finding)

                        <div class="box-comment">
                        <!-- User image -->
                        <img class="img-circle img-sm" src="/images/avatar-anonym.png" alt="User Image">

                          <div class="comment-text">
                                  <span class="username">
                                  {{$finding->user->name}}
                                  <span class="text-muted pull-right">{{$finding->created_at->toDayDateTimeString()}}</span>
                                  </span><!-- /.username -->
                                  {{$finding->user->name}} has answered <strong>{{$question->answers['answers'][$finding->finding['answer']]}}</strong>
                                  @if(!empty($finding->finding['inventory_id'])) and linked inventory  {{$inventories[$finding->finding['inventory_id']]->name}} @endif
                                  @if(!empty($finding->finding['rooms'])) in rooms  @foreach($finding->finding['rooms'] as $room_id) {{$rooms[$room_id]}}, @endforeach @endif
                                  @if(!empty($finding->finding['comment'])) commenting <i>{{$finding->finding['comment']}}</i> @endif
                          </div>
                        <!-- /.comment-text -->
                        </div>
                        <!-- /.box-comment -->

                        @endforeach

                    </div>
                    <!-- /.box-footer -->
                    <div class="box-footer">
                    </div>
                    <!-- /.box-footer -->
                </div>
            @endforeach
          </div>
    </div>
@endforeach

    <!-- Submit Button -->
    <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
            {!! Form::submit('Submit Answers', ['class' => 'btn btn-success pull-right'] ) !!}
        </div>
    </div>


{!! Form::close()  !!}

<!-- Positive Answer Modal -->
<div id="answerModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Answer Confirmation</h4>
      </div>
      <div class="modal-body">
        <p id="answer-text"></p>
        
        <div id="negative-div" style="display:none;">
            <div class="checkbox">
                <label><input type="checkbox" id="inventory-checkbox" value="">An inventory is associated with this finding</label>
            </div>

            <div class="form-group" id="inventory-div" style="display:none;">
                <label for="sel1">Inventory (Required)</label>
                <select class="form-control" id="inventory_id">
                    <option value="">Please Select</option>
                    @foreach($inventories as $inventory)
                        <option value="{{$inventory->id}}" data-room="{{$inventory->room_id}}">{{$inventory->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                {!! Form::label('rooms', 'Rooms (Required):', ['class' => '']) !!}
                {!! Form::select('rooms[]', $rooms->prepend('Please Select',''), '', ['class' => 'form-control selectpicker','id' => 'rooms','multiple' => true]); !!}
            </div>

            <div class="form-group">
                {!! Form::label('comment', 'Comment (Required):', ['class' => '']) !!}
                {!! Form::textarea('comment', $value = null, ['class' => 'form-control', 'placeholder' => 'comment','rows' => 3]) !!}
            </div>

            <div class="form-group dropzone-div">
                 <input type='hidden' name="attachment" value="">
                 {!! Form::label('attachment', 'Attachment (Optional):', ['class' => '']) !!}
                <div id="" class='dropzone'></div>
            </div>

        </div>

        <input type="hidden" id="answer" name="answer" value="">
        <input type="hidden" id="answer_text" name="answer_text" value="">
        <input type="hidden" id="attachment" name="attachment" value="">
        <input type="hidden" id="question_id" name="question_id" value="">
        <input type="hidden" id="rounding_id" name="rounding_id" value="{{$rounding->id}}">
        <input type="hidden" id="user_id" name="user_id" value="{{auth()->user()->id}}">
        <input type="hidden" id="is_negative" name="is_negative" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary confirm-finding">Confirm</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<script>

var user_id = '{{auth()->user()->id}}';
var rounding_id = '{{$rounding->id}}';

var rooms_data = '@php echo json_encode($rooms) @endphp';
var inventory_data = '@php echo json_encode($inventories) @endphp';

$('.answer').change(function(){

   
    $('#negative-div').hide();

    if($(this).val())
    {
        $('#answer-text').html('You have answered <strong>'+$(this).find('option:selected').text()+'</strong> for this question.');
        
        var question_id = $(this).attr('data-question-id');

        $('#answer').val($(this).val());
        $('#question_id').val(question_id);
        $('#is_negative').val(0);
        $('#answer_text').val($(this).find('option:selected').text());

        if($(this).val() == $(this).attr('data-negative'))
        {
            $('#rooms').val('');
            $('#comment').val('');
            $('#inventory-checkbox').prop('checked');
            $('#inventory-checkbox').change();
            $('#inventory_id').val('');

            $('#is_negative').val(1);

            var directory = 'rounding/'+rounding_id+'/question/'+question_id+'/user/'+user_id+'/findings';
            var random_number = Math.floor((Math.random() * 10000) + 1);
            $('#attachment').val(directory);

            $('.dropzone').remove();
            $('.dropzone-div').append('<div id="" class="dropzone"></div>');
            $('.dropzone').attr('id','dropzone_'+random_number);

            $('#dropzone_'+random_number).dropzone({ 
                url: "/dropzone/upload",
                init: function() {
                this.on('sending', function(file, xhr, formData){
                    formData.append('_token', $('meta[name=\"csrf-token\"]').attr('content'));
                    formData.append('folder', directory);
                });
            }
            });

            $('#negative-div').show();
        }
        else
        {

        }
    }

     $('#answerModal').modal('show');

});

$('#inventory-checkbox').change(function(){
        if(this.checked){
            $('#inventory-div').show();
            $('#inventory_id').selectpicker('val', 0);
        }
        else{
            $('#inventory-div').hide();
            $('#inventory_id').selectpicker('val', 0);
            //$('#building_department_id').prop('readonly',false);
            enableAll('rooms');
            //$('#room_id').prop('readonly',false);
            $('#rooms').selectpicker('val', '');
            $('#rooms').selectpicker('refresh');

        }
    });

    $("#inventory_id").change(function(){
            $('#rooms').val($('#inventory_id option:selected').attr('data-room')).change();
            enableAllExcept('rooms',$('#inventory_id option:selected').attr('data-room'));
            $('#rooms').selectpicker('refresh');
    });


    $(document).on('click', '.confirm-finding', function () {
        
        var finding = {};

        if($('#is_negative').val() == 1)
        {
            if($('#inventory-checkbox').is(':checked'))
            {
                if($('#inventory_id').val())
                {
                  finding['inventory_id'] = $('#inventory_id').val();
                }
                else
                {
                  alert('Inventory cannot be empty.');
                  return 0;
                }
            }

              //lets do rooms

              var rooms = $('#rooms').val();

              var i;

              finding['rooms'] = [];

              for (i = 0; i < rooms.length; i++) { 
                
                if(rooms[i])
                {
                  finding['rooms'].push(rooms[i]);
                }
                
              }

              if(finding['rooms'].length == 0)
              {
                  alert('Atleast one room should be selected.');
                  return 0;
              }


            //comment

            if($('#comment').val())
            {
              finding['comment'] = $('#comment').val();
            }
            else
            {
                alert('A comment is required.');
                return 0;
            }

            //attachment
            finding['attachment'] = $('#attachment').val();

        }
        else
        {
            finding['comment'] = '';
            finding['attachment'] = '';
            finding['rooms'] = [];

        }

        //answer

        finding['answer'] = $('#answer').val();


        var rounding_id = $('#rounding_id').val();
        var question_id = $('#question_id').val();
        var answer_text = $('#answer_text').val();

        $('#answerModal').modal('hide');

        $('#question_'.question_id).val('');

        $.ajax({
           type: 'POST',
           url: '{{ url('rounding/'.$rounding->id.'/question/findings') }}',
           data: { 
             '_token' : '{{ csrf_token() }}',
             'rounding_id' : rounding_id,
             'question_id' : question_id,
             'user_id' : user_id,
             'finding' : JSON.stringify(finding)
             },

           beforeSend:function(){
             
           },
           success:function(data)
           { 
              var negative_html = '';

              if($('#is_negative').val() == 1)
              {
                  if($('#inventory-checkbox').is(':checked'))
                  {
                      if($('#inventory_id').val())
                      {
                        $.each( JSON.parse(inventory_data), function( key, value ) {
                          if(value.id == $('#inventory_id').val())
                          {
                            negative_html += ' and has linked inventory '+value.name;
                          }
                        });
                      }
                  }

                  var room_html = '';

                  $.each( JSON.parse(rooms_data), function( key, value ) {

                    if($('#rooms').val().includes(key))
                    {
                      room_html += value + ',';
                    }
                  });

                  negative_html += ' for rooms '+room_html;

                  //comment

                  negative_html += ' and has commented '+$('#comment').val();

              }             
              
              var main_html = `<div class="box-comment">
                        <!-- User image -->
                        <img class="img-circle img-sm" src="/images/avatar-anonym.png" alt="User Image">

                        <div class="comment-text">
                                <span class="username">
                                {{auth()->user()->name}}
                                <span class="text-muted pull-right">${moment().calendar()}</span>
                                </span><!-- /.username -->
                            {{auth()->user()->name}} has answered ${answer_text} ${negative_html}
                        </div>
                        <!-- /.comment-text -->
                        </div>`;  

                $('#box-footer-'+question_id).append(main_html);
           },
           complete:function(){}
        });

    });

    function enableAllExcept(selector,value)
    {
          $('#'+selector+' option').each(function() {
              if($(this).val() != value) {
                  $(this).attr('disabled', true);
              }
          });
    }

    function enableAll(selector)
    {
          $('#'+selector+' option').each(function() {
              $(this).attr('disabled', false);
          });
    }


</script>

@endsection
