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
			<div class="row main">
				<div class="panel-heading">
	               <div class="panel-title text-center">
	               		<h2 class="title">Register for User Access</h2>
	               		<hr />
	               	</div>
	            </div>
              @include('layouts.partials.success')
				<div class="main-login main-center">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('prospects/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required >

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required >

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">Address</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                          <div class="form-group">
                              {!! Form::label('departments', 'Departments:', ['class' => 'col-md-4 control-label']) !!}
                              <div class="col-md-6">
                                {!!  Form::select('departments[]', $departments, $selected = null, ['class' => 'form-control selectpicker','multiple' => true,'id' => 'departments']) !!}
                              </div>
                          </div>


                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">Contractor</label>

                            <div class="col-md-6">
                                <div class="checkbox">
                                  <label><input type="checkbox" id="is_contractor" name="is_contractor" value="1">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div id="optional" style="display:none">
                          <div class="form-group{{ $errors->has('corporation') ? ' has-error' : '' }}">
                              <label for="corporation" class="col-md-4 control-label">Corporation</label>

                              <div class="col-md-6">
                                  <input id="corporation" type="text" class="form-control" name="corporation" value="{{ old('corporation') }}" >

                                  @if ($errors->has('corporation'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('corporation') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group{{ $errors->has('partnership') ? ' has-error' : '' }}">
                              <label for="partnership" class="col-md-4 control-label">Partnership</label>

                              <div class="col-md-6">
                                  <input id="partnership" type="text" class="form-control" name="partnership" value="{{ old('partnership') }}" >

                                  @if ($errors->has('partnership'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('partnership') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group{{ $errors->has('sole_prop') ? ' has-error' : '' }}">
                              <label for="sole_prop" class="col-md-4 control-label">Sole Prop</label>

                              <div class="col-md-6">
                                  <input id="sole_prop" type="text" class="form-control" name="sole_prop" value="{{ old('sole_prop') }}" >

                                  @if ($errors->has('sole_prop'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('sole_prop') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group{{ $errors->has('company_owner') ? ' has-error' : '' }}">
                              <label for="company_owner" class="col-md-4 control-label">Owner of Company</label>

                              <div class="col-md-6">
                                  <input id="company_owner" type="text" class="form-control" name="company_owner" value="{{ old('company_owner') }}">

                                  @if ($errors->has('company_owner'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('company_owner') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group{{ $errors->has('contract_license_number') ? ' has-error' : '' }}">
                              <label for="contract_license_number" class="col-md-4 control-label">Contractor License Number</label>

                              <div class="col-md-6">
                                  <input id="contract_license_number" type="text" class="form-control" name="contract_license_number" value="{{ old('contract_license_number') }}" >

                                  @if ($errors->has('contract_license_number'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('contract_license_number') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group">
                              {!! Form::label('trades', 'Trades:', ['class' => 'col-md-4 control-label']) !!}
                              <div class="col-md-6">
                                {!!  Form::select('trades[]', $trades, $selected = null, ['class' => 'form-control selectpicker','multiple' => true]) !!}
                              </div>
                          </div>



                        </div>




                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                  </div>
          			</div>
          		</div>

              <script src="{{ asset ("/bower_components/jquery/dist/jquery.min.js") }}" type="text/javascript"></script>
              <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
              <script src="{{ asset ("/bower_components/bootstrap/dist/js/bootstrap.min.js") }}" type="text/javascript"></script>
          	</body>
          </html>

          <script>
            $("#is_contractor").click(function(){
              if (this.checked) {
                $("#optional").show();
                $("#departments").prop('disabled',true)
            }
            else {
              $("#optional").hide();
              $("#departments").prop('disabled',false)
            }
            });
          </script>
