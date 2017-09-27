<aside class="main-sidebar">
<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="/images/contact-icon.png" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p>@if(Auth::guard('admin')->check()) {{Auth::guard('admin')->user()->name}} @else {{Auth::guard('web')->user()->name}} @endif</p>
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
  @if(Auth::guard('admin')->check())
    <ul class="sidebar-menu">
      <li class="header text-yellow"><strong>ADMIN</strong></li>
      <li class="treeview">
           <a href="#">
             <i class="fa fa-files-o"></i>
             <span>Regulatory</span>
             <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i></span>
             </span>
           </a>
           <ul class="treeview-menu">
             <li><a href="{{url('admin/accreditation')}}"><i class="fa fa-circle-o"></i>Accreditation</a></li>
             <li><a href="{{url('admin/accreditation-requirements')}}"><i class="fa fa-circle-o"></i>Accreditation Requirements</a></li>
             <li><a href="{{url('admin/standard-label')}}"><i class="fa fa-circle-o"></i>TJC Standards & EP's</a></li>
             <li><a href="{{url('admin/aorn')}}"><i class="fa fa-circle-o"></i>AORN Standards</a></li>
             <li><a href="{{url('admin/cop')}}"><i class="fa fa-circle-o"></i>CMS COP</a></li>
           </ul>
       </li>

       <li class="treeview">
            <a href="#">
              <i class="fa fa-files-o"></i>
              <span>Work Orders</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{url('admin/work/assignees')}}"><i class="fa fa-circle-o"></i>Assignees</a></li>
            </ul>
        </li>

        <li class="treeview">
             <a href="#">
               <i class="fa fa-files-o"></i>
               <span>Clients</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
             <ul class="treeview-menu">
               <li><a href="{{url('admin/healthsystem')}}"><i class="fa fa-circle-o"></i>Health System</a></li>
               <li><a href="{{url('admin/healthsystem/users')}}"><i class="fa fa-circle-o"></i>System Admins</a></li>
               <li><a href="{{url('admin/healthsystem/prospects')}}"><i class="fa fa-circle-o"></i>Prospect Users</a></li>
             </ul>
         </li>
    </ul>
  @endif

@if(Auth::guard('web')->check())
  @if(Auth::guard('web')->user()->roles->contains('name','System Admin'))
  <ul class="sidebar-menu">
    <li class="header text-yellow"><strong>SYSTEM ADMIN</strong></li>
    <li class="treeview">
         <a href="#">
           <i class="fa fa-files-o"></i>
           <span>Users</span>
           <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i></span>
           </span>
         </a>
         <ul class="treeview-menu">
           <li><a href="{{url('users')}}"><i class="fa fa-circle-o"></i>Users</a></li>
           <li><a href="{{url('users/prospects')}}"><i class="fa fa-circle-o"></i>Prospects</a></li>
           
         </ul>
     </li>
     <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i></span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('prequalify')}}"><i class="fa fa-circle-o"></i>Prequalify Form</a></li>
          </ul>
      </li>
  </ul>
  @endif
@endif

@if(Auth::guard('web')->check())
  @if(Auth::guard('web')->user()->isContractorProspect())
  <ul class="sidebar-menu">
    <li class="header text-yellow"><strong>PROSPECT</strong></li>
    <li class="treeview">
         <a href="#">
           <i class="fa fa-files-o"></i>
           <span>Application</span>
           <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i></span>
           </span>
         </a>
         <ul class="treeview-menu">
           <li><a href="{{url('contractor/prequalify')}}"><i class="fa fa-circle-o"></i>Prequalify</a></li>
         </ul>
     </li>
  </ul>

  @endif
@endif
</section>
</aside>
