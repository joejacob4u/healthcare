<!DOCTYPE html>
<html lang="en">
    <head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">


		<!-- Website CSS style -->
		<link rel="stylesheet" type="text/css" href="assets/css/main.css">

		<!-- Website Font style -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

		<!-- Google Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
    <script src="{{ asset ("/bower_components/jquery/dist/jquery.min.js") }}" type="text/javascript"></script>

		<title>Admin</title>
    <style>
          body, html{
         height: 100%;
      background-repeat: no-repeat;
      background-color: #d3d3d3;
      font-family: 'Oxygen', sans-serif;
      }

      .main{
      margin-top: 70px;
      }

      h1.title {
      font-size: 50px;
      font-family: 'Passion One', cursive;
      font-weight: 400;
      }

      hr{
      width: 10%;
      color: #fff;
      }

      .form-group{
      margin-bottom: 15px;
      }

      label{
      margin-bottom: 15px;
      }

      input,
      input::-webkit-input-placeholder {
        font-size: 11px;
        padding-top: 3px;
      }

      .main-login{
      background-color: #fff;
        /* shadows and rounded borders */
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;
        -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

      }

      .main-center{
      margin-top: 30px;
      margin: 0 auto;
      max-width: 600px;
        padding: 40px 40px;

      }

      .login-button{
      margin-top: 5px;
      }

      .login-register{
      font-size: 11px;
      text-align: center;
      }

    </style>
	</head>
	<body>
		<div class="container">
        <div id="form-olvidado">
                <h4 class="">
                Forgot your password?
                </h4>
                <form accept-charset="UTF-8" role="form" id="login-recordar" method="post" action="{{url('forgot/password')}}">
                <fieldset>
                    <span class="help-block">
                    Email address you use to log in to your account
                    <br>
                    We'll send you an email with instructions to choose a new password.
                    </span>
                    <div class="form-group input-group">
                    <span class="input-group-addon">
                        @
                    </span>
                    <input class="form-control" placeholder="Email" name="email" type="email" required="">
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary btn-block" id="btn-olvidado">
                    Continue
                    </button>
                    <p class="help-block">
                    <a class="text-muted" href="#" id="acceso"><small>Account Access</small></a>
                    </p>
                </fieldset>
                </form>
            </div>
        </div>

              <script src="{{ asset ("/bower_components/jquery/dist/jquery.min.js") }}" type="text/javascript"></script>
              <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
              <script src="{{ asset ("/bower_components/bootstrap/dist/js/bootstrap.min.js") }}" type="text/javascript"></script>
          	</body>
          </html>

          <script>
            $("#checkbox").click(function(){
              if (this.checked) {
                $("#optional").show();
            }
            else {
              $("#optional").hide();
            }
            });
          </script>
