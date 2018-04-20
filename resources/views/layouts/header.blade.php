<header class="main-header">
  <!-- Logo -->
  <a href="index2.html" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>A</b>LT</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>HealthCare</b>360</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
@if(Auth::guard('admin')->check() or Auth::guard('system_user')->check() or Auth::guard('contractor')->check())
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        <li class="dropdown messages-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-flag"></i>
            <span class="label label-danger"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="header"></li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
              </ul>
            </li>
            <li class="footer"><a href="#">See All My Findings</a></li>
          </ul>
        </li>
        <!-- Notifications: style can be found in dropdown.less -->
        
        <!-- Tasks: style can be found in dropdown.less -->
        
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-hospital-o" aria-hidden="true"></i>
            <span class="hidden-xs">@if(session()->has('building_id')) {{session('hco_name')}} / {{session('building_name')}} @else Set Building @endif</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
            <i class="fa fa-hospital-o fa-5x" aria-hidden="true"></i>

              <p>
                @if(session()->has('building_id')) {{session('site_name')}} @else Set Building @endif
                <small>@if(session()->has('building_id')) {{session('hco_name')}} @else Set Building @endif</small>
              </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
            
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="#" id="change_building_button" class="btn btn-default btn-flat">Set/Change Building</a>
              </div>
              <div class="pull-right">
                <a href="{{url('logout')}}" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
      </ul>
    </div>
    @endif
  </nav>
</header>
