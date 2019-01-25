<html><head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/bower_components/dropzone/dist/dropzone.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="/bower_components/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/bower_components/AdminLTE/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css">

  <!-- iCheck -->
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/blue.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<style>
.login-box, .register-box {
    width: 600px !important;
}
</style>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#">New Demand Work Order</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    @include('layouts.partials.success')

    <p class="login-box-msg">Fill this form out to submit request</p>

    {!! Form::open(['url' => 'demand-work-order/'.$healthsystem_id.'/new', 'class' => '']) !!}
        <div class="form-group">
            {!! Form::label('requester_name', 'Requester Name:', ['class' => 'control-label']) !!}
            {!! Form::text('requester_name', Request::old('requester_name'), ['class' => 'form-control','id' => 'requester_name']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('requester_email', 'Requester E-Mail:', ['class' => 'control-label']) !!}
            {!! Form::text('requester_email', Request::old('requester_email'), ['class' => 'form-control','id' => 'requester_email']) !!}
        </div>
      <div class="form-group">
        {!! Form::label('hco_id', 'HCO:', ['class' => 'control-label']) !!}
        {!! Form::select('hco_id', $hcos, Request::old('hco_id'), ['class' => 'form-control selectpicker','id' => 'hco_id']); !!}
      </div>
        <div class="form-group">
            {!! Form::label('site_id', 'Site:', ['class' => 'control-label']) !!}
            {!! Form::select('site_id', [], '', ['class' => 'form-control','id' => 'site_id','data-live-search' => "true"]); !!}
        </div>

        <div class="form-group">
            {!! Form::label('building_id', 'Building:', ['class' => 'control-label']) !!}
            {!! Form::select('building_id', [], '', ['class' => 'form-control','id' => 'building_id','data-live-search' => "true"]); !!}
        </div>
        <div class="checkbox">
            <label><input type="checkbox" id="inventory-checkbox" value="">An inventory is associated with this request</label>
        </div>
        <div class="form-group" id="inventory-div" style="display:none;">
            {!! Form::label('inventory_id', 'Inventory:', ['class' => 'control-label']) !!}
            {!! Form::select('inventory_id', [], '', ['class' => 'form-control','id' => 'inventory_id','data-live-search' => "true"]); !!}
        </div>

        <div class="form-group">
            {!! Form::label('building_department_id', 'Department:', ['class' => 'control-label']) !!}
            {!! Form::select('building_department_id', [], '', ['class' => 'form-control selectpicker','id' => 'building_department_id','data-live-search' => "true"]); !!}
        </div>

        <div class="form-group">
            {!! Form::label('room_id', 'Room:', ['class' => 'control-label']) !!}
            {!! Form::select('room_id', [], '', ['class' => 'form-control','id' => 'room_id','data-live-search' => "true"]); !!}
        </div>

        <div class="form-group">
            {!! Form::label('work_order_trade_id', 'Trade:', ['class' => 'control-label']) !!}
            {!! Form::select('work_order_trade_id', $trades->prepend('Select Trade',0), '', ['class' => 'form-control selectpicker','id' => 'work_order_trade_id','data-live-search' => "true"]); !!}
        </div>

        <div class="form-group">
            {!! Form::label('work_order_problem_id', 'Problem:', ['class' => 'control-label']) !!}
            {!! Form::select('work_order_problem_id', [], '', ['class' => 'form-control selectpicker','id' => 'work_order_problem_id','data-live-search' => "true"]); !!}
        </div>

        <div class="form-group" id="work_order_priority_id-div">
            <label for="work_order_priority_id">Priority:</label>
            {!! Form::select('work_order_priority_id',$work_order_priorities->prepend('Please Select',0), $value = '', ['class' => 'form-control','id' => 'work_order_priority_id']) !!}
            <span class="help-block"></span>
        </div>


        <div class="form-group">
            {!! Form::label('comments', 'Comment:', ['class' => 'control-label']) !!}
            {!! Form::textarea('comments', Request::old('comments'), ['class' => 'form-control','id' => 'comments','rows' => '3']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('attachments_path', 'Attachments (Optional)', ['class' => 'control-label']) !!}
            {!! HTML::dropzone('attachments_path','demand_work_orders/'.$healthsystem_id.'/'.time(),'false') !!}
        </div>






      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="button" onclick="validateForm()" class="btn btn-primary btn-block btn-flat">Submit</button>
        </div>
        <!-- /.col -->
      </div>
    {!! Form::close() !!}

</div>
<!-- /.login-box -->

  <script src="{{ asset ("/bower_components/jquery/dist/jquery.min.js") }}" type="text/javascript"></script>
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
  <script src="{{ asset ("/bower_components/bootstrap/dist/js/bootstrap.min.js") }}" type="text/javascript"></script>
  <script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>
  <script src="{{ asset ("/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js") }}" type="text/javascript"></script>
  <script src="{{ asset ("/bower_components/dropzone/dist/dropzone.js") }}" type="text/javascript"></script>
  <script>
    Dropzone.autoDiscover = false;
  </script>

<script>
    $("#hco_id").change(function(){
        
        var hco_id = $("#hco_id").val();

        $.ajax({
          type: 'POST',
          url: '{{ url('system-admin/accreditation/fetch/sites') }}',
          data: { '_token' : '{{ csrf_token() }}', 'hco_id': hco_id },
          beforeSend:function()
          {
          },
          success:function(data)
          {
            $('#site_id').html('');

            var html = '<option value="0">Select Site</option>';

            $.each(data.sites, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+' ('+value.address+' ) - #'+value.site_id+'</option>';
            });

            $('#site_id').append(html);
            $('#site_id').selectpicker('refresh');
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



      });

      $("#site_id").change(function(){
        
        var site_id = $("#site_id").val();

        $.ajax({
          type: 'POST',
          url: '{{ url('system-admin/accreditation/fetch/buildings') }}',
          data: { '_token' : '{{ csrf_token() }}', 'site_id': site_id },
          beforeSend:function()
          {
            $('#accreditation_modal .callout').show();
          },
          success:function(data)
          {
            $('#building_id').html('');

            var html = '<option value="0">Select Building</option>';

            $.each(data.buildings, function(index, value) {
                html += '<option value="'+value.id+'">'+value.name+'- #'+value.building_id+'</option>';
            });

            $('#building_id').append(html);
            $('#building_id').selectpicker('refresh');
            $('#accreditation_modal .callout').hide();

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
      });

    $('#inventory-checkbox').change(function(){
        if(this.checked){
            $('#inventory-div').show();
            $('#inventory_id').selectpicker('val', 0);
        }
        else{
            $('#inventory-div').hide();
            $('#inventory_id').selectpicker('val', 0);
            $('#building_department_id').prop('disabled',false);
            $('#room_id').prop('disabled',false);
            $('#building_department_id').selectpicker('render');
            $('#room_id').selectpicker('render');

        }
    });

    $("#building_id").change(function(){
        
        var building_id = $("#building_id").val();

        $.ajax({
          type: 'POST',
          url: '{{ url('equipment/inventory/fetch-for-building') }}',
          data: { '_token' : '{{ csrf_token() }}', 'building_id': building_id },
          beforeSend:function()
          {
          },
          success:function(data)
          {
            $('#inventory_id').html('');

            var html = '<option value="0">Select Inventory</option>';

            $.each(data.inventories, function(index, value) {
                html += '<option value="'+value.id+'" data-department-id="'+value.department_id+'" data-room-id="'+value.room_id+'">'+value.name+'</option>';
            });

            $('#inventory_id').append(html);
            $('#inventory_id').selectpicker('refresh');
            $('#inventory-div').hide();
            $('#inventory-checkbox').prop('checked',false);

            fetchDepartments(building_id);


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

      });

    $("#inventory_id").change(function(){
        $('#building_department_id').val($('#inventory_id option:selected').attr('data-department-id')).change();
        $('#building_department_id').selectpicker('refresh');
        $('#building_department_id').prop('disabled',true);
        
        window.setTimeout(function(){
            $('#room_id').val($('#inventory_id option:selected').attr('data-room-id')).change();
            $('#room_id').selectpicker('refresh');
            $('#room_id').prop('disabled',true);
        }, 1500);

        
        

    });


    $("#building_department_id").change(function(){

        if($(this).val() != 0)
        {
                $.ajax({
                type: 'POST',
                url: '{{ url('system-admin/accreditation/eop/status/fetch/rooms') }}',
                data: { '_token' : '{{ csrf_token() }}', 'department_id': $(this).val() },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    $('#room_id').html('');

                    var html = '<option value="0">Select Room</option>';

                    $.each(data.rooms, function(index, value) {
                        html += '<option value="'+value.id+'">'+value.room_number+'</option>';
                    });

                    $('#room_id').append(html);
                    $('#room_id').selectpicker('refresh');
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


    $('#work_order_trade_id').change(function(){
        if($(this).val() != 0)
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('work-order/trades/fetch-problems') }}',
                data: { '_token' : '{{ csrf_token() }}', 'trade_id': $(this).val() },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    $('#work_order_problem_id').html('');

                    var html = '<option value="0">Select Problem</option>';

                    $.each(data.problems, function(index, value) {
                        html += '<option value="'+value.id+'" data-work_order_priority_id="'+value.priority.id+'" data-work_order_priority_text="'+value.priority.name+'">'+value.name+'</option>';
                    });

                    $('#work_order_problem_id').append(html);
                    $('#work_order_problem_id').selectpicker('refresh');
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

    $('#work_order_problem_id').change(function(){

        var work_order_priority_id = $('#work_order_problem_id option:selected').attr('data-work_order_priority_id');
        $('#work_order_priority_id').val(work_order_priority_id);
        $('#work_order_priority_id-div').addClass('has-warning');
        $('#work_order_priority_id-div .help-block').html('Pre-determined Priority : '+$('#work_order_priority_id option:selected').text());
    });

    $('#work_order_priority_id').change(function(){

        var work_order_priority_id = $('#work_order_priority_id').val();
        var existing_text;

        if(work_order_priority_id != $('#work_order_problem_id option:selected').attr('data-work_order_priority_id'))
        {
            var is_step_up = $('#work_order_problem_id option:selected').attr('data-work_order_priority_id') - work_order_priority_id;
            if(is_step_up > 1)
            {
                existing_text = $('#work_order_priority_id-div .help-block').html();
                $('#work_order_priority_id-div .help-block').html('');
                $('#work_order_priority_id-div .help-block').html(existing_text+'<br>Are you sure this priority is needed above the standard priority? Senior leadership will be notified of the increased urgency over other issues to make sure it obtains the needed attention for resolution.');
            }
            else
            {
                $('#work_order_priority_id').val(work_order_priority_id);
                $('#work_order_priority_id-div').addClass('has-warning');
                $('#work_order_priority_id-div .help-block').html('Pre-determined Priority : '+$('#work_order_problem_id option:selected').attr('data-work_order_priority_text'));

            }
        }
        else
        {
            $('#work_order_priority_id').val(work_order_priority_id);
            $('#work_order_priority_id-div').addClass('has-warning');
            $('#work_order_priority_id-div .help-block').html('Pre-determined Priority : '+$('#work_order_problem_id option:selected').attr('data-work_order_priority_text'));
        }
    });

      // fetch departments via building

    function fetchDepartments(building_id){

        if(building_id)
        {
                $.ajax({
                type: 'POST',
                url: '{{ url('buildings/fetch/departments') }}',
                data: { '_token' : '{{ csrf_token() }}', 'building_id': building_id },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    $('#building_department_id').html('');

                    var html = '<option value="0">Select Department</option>';

                    $.each(data.departments, function(index, value) {
                        html += '<option value="'+value.id+'">'+value.name+'</option>';
                    });

                    $('#building_department_id').append(html);
                    $('#building_department_id').selectpicker('refresh');
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
        
      }

      function validateForm()
      {
          $(".form-control[aria-label!='Search']").not('.bootstrap-select').each(function(index,elem){
            
            if($(this).val() && $(this).val() != 0)
            {
            }
            else
            {
                if($(this).attr('name') == 'inventory_id' && !$('#inventory-checkbox').is(':checked'))
                {

                }
                else if($(this).attr('name') == 'comments')
                {

                }
                else
                {
                    alert($(this).closest(".form-group").find("label").html()+' must be entered.');
                    return false;
                }
            }
          });
          
            $("form").submit();
      }




</script>


</body></html>