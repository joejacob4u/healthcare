<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 2.3.8
  </div>
  <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
  reserved.
</footer>
@if(Auth::check()) {
@include('accreditation.partials.accreditation_modal')
@endif

<!-- Modal -->
<div id="changePasswordModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change your temporary password</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
            <fieldset>

            <!-- Password input-->
            <div class="form-group">
            <label class="col-md-4 control-label" for="passwordinput">Temporary Password</label>
            <div class="col-md-6">
                <input id="oldpassword" name="oldpassword" type="password" placeholder="old password" class="form-control input-md">
            </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
            <label class="col-md-4 control-label" for="passwordinput">New Password</label>
            <div class="col-md-6">
                <input id="newpassword" name="newpassword" type="password" placeholder="new password" class="form-control input-md">
            </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
            <label class="col-md-4 control-label" for="passwordinput">Confirm Password</label>
            <div class="col-md-6">
                <input id="confirmpassword" name="confirmpassword" type="password" placeholder="confirm password" class="form-control input-md">
            </div>
            </div>

            </fieldset>
            </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Not Now</button>
        <button type="button" onclick="changePassword()" class="btn btn-primary">Change Password</button>
      </div>
    </div>

  </div>
</div>

<script>
$(document).ready(function(){
    
    $('table').DataTable({
      initComplete: function () {
          this.api().columns().every( function () {
              var column = this;
              var select = $('<select><option value=""></option></select>')
                  .appendTo( $(column.footer()).empty() )
                  .on( 'change', function () {
                      var val = $.fn.dataTable.util.escapeRegex(
                          $(this).val()
                      );

                      column
                          .search( val ? '^'+val+'$' : '', true, false )
                          .draw();
                  } );

              column.data().unique().sort().each( function ( d, j ) {
                  if(d.length < 30)
                  {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                  }
              } );
          } );
      }
    });


});

$(function() {
    $.ajax({
            type: 'POST',
            url: '{{ asset('user/password/temporary/check') }}',
            data: { '_token' : '{{ csrf_token() }}' },
            beforeSend:function()
            {
                
            },
            success:function(data)
            {
                if(data == '1')
                {
                    $('#changePasswordModal').modal('show');
                }
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

function changePassword()
{
        var old_password = $('#changePasswordModal #oldpassword').val();
        var new_password = $('#changePasswordModal #newpassword').val();
        var confirm_password = $('#changePasswordModal #confirmpassword').val();

        if(new_password != confirm_password)
        {
            bootbox.alert("Passwords do not match!");
        }

        $.ajax({
            type: 'POST',
            url: '{{ url('user/password/temporary/change') }}',
            data: { '_token' : '{{ csrf_token() }}','old_password' : old_password,'new_password' : new_password,'confirm_password' : confirm_password },
            beforeSend:function()
            {
                
            },
            success:function(data)
            {
                if(data == 'true')
                {
                    $('#changePasswordModal').modal('hide');
                    bootbox.alert("Password has been successfully changed");
                }
                else if(data == 'false')
                {
                    bootbox.alert("Old password incorrect, try again");
                }
            },
            error:function(data)
            {

            },
            complete: function(data)
            {
                $('.overlay').remove();
            }
        });

}

$("#healthsystem_tree").click(function(){
    var building_id = $('#building_id_meta_value').attr('content');
    
    if(building_id == 0)
    {
        $("#accreditation_modal").modal('show');
    }

})

$("#change_building_button").click(function(){
    $("#accreditation_modal").modal('show');
})


var hash = window.location.hash;
hash && $('ul.nav a[href="' + hash + '"]').tab('show');



  $('.nav-tabs a').click(function (e) {
    $(this).tab('show');
    var scrollmem = $('body').scrollTop();
    window.location.hash = this.hash;
    $('html,body').scrollTop(scrollmem);
  });

</script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyAPvAvVpdt1rZjrOgJgoSFTik-llRJbmCg"></script>
<script type="text/javascript">
    google.maps.event.addDomListener(window, 'load', function () {
        var places = new google.maps.places.Autocomplete(document.getElementById('address'));
        google.maps.event.addListener(places, 'place_changed', function () {

        });
    });
</script>