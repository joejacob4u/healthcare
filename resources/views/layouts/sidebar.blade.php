<aside class="main-sidebar">
<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="/images/contact-icon.png" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p>{{Auth::user()->name}}</p>
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
  </div>
  <!-- search form -->
  <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
    </div>
  </form>
  <!-- /.search form -->
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
    <li class="header text-light-blue"><strong>REGULATORY</strong></li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-certificate"></i> <span>Accreditation</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @foreach($client->departments as $department)
        <li>
          <a href="#"><i class="fa fa-circle-o"></i> {{$department->name}}
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @foreach($accr_types as $accr_type)
              <li><a href="{{url($department->slug.'/'.$accr_type->slug)}}"><i class="fa fa-circle-o"></i> {{$accr_type->name}}</a></li>
            @endforeach
          </ul>
        </li>
        @endforeach
      </ul>
    </li>

    <li class="header text-yellow"><strong>ADMIN</strong></li>
    <li><a href="{{url('admin/clients')}}"><i class="fa fa-hospital-o" aria-hidden="true"></i> <span>Clients</span></a></li>
    <li><a href="{{url('admin/accreditation')}}"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> <span>Accreditation Requirements</span></a></li>
  </ul>
</section>
</aside>
