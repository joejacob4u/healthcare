<aside class="main-sidebar">
<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="/images/contact-icon.png" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p>@if(Auth::guard('admin')->check()) {{Auth::guard('admin')->user()->name}} @elseif(Auth::guard('system_user')->check()) {{Auth::guard('system_user')->user()->name}} @else {{Auth::guard('contractor')->user()->name}}  @endif</p>
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
             <span>Maintenance</span>
             <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i></span>
             </span>
           </a>
           <ul class="treeview-menu">
             <li><a href="{{url('admin/maintenance/trades')}}"><i class="fa fa-circle-o"></i>Trades</a></li>
             <li><a href="{{url('admin/maintenance/categories')}}"><i class="fa fa-circle-o"></i>Categories</a></li>
             <li><a href="{{url('admin/maintenance/asset-categories')}}"><i class="fa fa-circle-o"></i> Asset Categories</a></li>

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
               <li><a href="{{url('healthsystem')}}"><i class="fa fa-circle-o"></i>Health System</a></li>
               <li><a href="{{url('healthsystem/users')}}"><i class="fa fa-circle-o"></i>System Admins</a></li>
               <li><a href="{{url('healthsystem/prospects')}}"><i class="fa fa-circle-o"></i>Prospect Users</a></li>
             </ul>
         </li>
    </ul>
  @endif

@if(Auth::guard('system_user')->check())
  @if(Auth::guard('system_user')->user()->role->name == 'System Admin')
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
     <li><a href="{{url('healthsystem/'.Auth::guard('system_user')->user()->healthsystem_id.'/hco')}}"><i class="fa fa-circle-o"></i>Manage HCOs</a></li>
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
            <li><a href="{{url('system_admin/verifiers')}}"><i class="fa fa-circle-o"></i>Verifiers</a></li>
          </ul>
      </li>
      <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Project</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i></span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('projects')}}"><i class="fa fa-circle-o"></i>Projects</a></li>
            <li><a href="{{url('project/ranking-questions')}}"><i class="fa fa-circle-o"></i>Ranking Questions</a></li>
          </ul>
      </li>
      <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Prequalify Form</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i></span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('workflows')}}"><i class="fa fa-circle-o"></i>Workflows</a></li>
            <li><a href="{{url('workflows/approval-level-leaders')}}"><i class="fa fa-circle-o"></i>Approval Level Leaders</a></li>
            <li><a href="{{url('workflows/administrative-leaders')}}"><i class="fa fa-circle-o"></i>Administrative Leaders</a></li>
            <li><a href="{{url('workflows/accreditation-compliance-leaders')}}"><i class="fa fa-circle-o"></i>Accreditation Compliance Leaders</a></li>
            <li><a href="{{url('workflows/business-units')}}"><i class="fa fa-circle-o"></i>Business Units</a></li>
            <li><a href="{{url('workflows/financial-category-codes')}}"><i class="fa fa-circle-o"></i>Financial Category Codes</a></li>
          </ul>
      </li>
      <li><a href="{{url('tjc_checklist/eops')}}"><i class="fa fa-circle-o"></i>TJC Checklist</a></li>

      @if(Auth::guard('system_user')->user()->role->name == 'System Admin' || Auth::guard('system_user')->user()->role->name == 'Facility Manager/Director')

      <li class="treeview">
         <a href="#">
           <i class="fa fa-files-o"></i>
           <span>Maintenance</span>
           <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i></span>
           </span>
         </a>
         <ul class="treeview-menu">
           <li><a href="{{url('admin/maintenance/users')}}"><i class="fa fa-circle-o"></i>Maintenance Users</a></li>
           <li><a href="{{url('admin/maintenance/shifts')}}"><i class="fa fa-circle-o"></i>Maintenance Schedule</a></li>
         </ul>
     </li>

     @endif

      @if(session()->has('building_id'))
        <li class="header text-yellow"><i class="fa fa-building" aria-hidden="true"></i>&emsp;<strong> {{strtoupper(session('building_name'))}}</strong></li>
        @endif

        @if(session()->has('building_id'))
          <li class="treeview @if(\Request::is('system-admin/accreditation/*')) active @endif" id="healthsystem_tree">
            <a href="#">
              <i class="fa fa-circle-o"></i><span>Accreditation</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i></span>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{url('accreditation/dashboard')}}"><i class="fa fa-circle-o text-blue"></i> <span>Dashboard</span></a></li>
              <li><a href="{{url('tjc_checklist')}}"><i class="fa fa-circle-o text-yellow"></i> <span>TJC Checklist</span></a></li>
              @foreach($sidebar_building->accreditations as $accreditation)
                  <li class="treeview @if(\Request::is('system-admin/accreditation/'.$accreditation->id.'/*')) active @endif">
                    <a href="#">
                      <i class="fa fa-circle-o"></i><span>{{$accreditation->name}}</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i></span>
                      </span>
                    </a>
                <ul class="treeview-menu">
                  @foreach($accreditation->accreditationRequirements as $accreditation_requirement)
                    <li class="@if(\Request::is('system-admin/accreditation/'.$accreditation->id.'/accreditation_requirement/'.$accreditation_requirement->id)) active @endif" style="white-space: pre-line;"><a href="{{url('system-admin/accreditation/'.$accreditation->id.'/accreditation_requirement/'.$accreditation_requirement->id)}}"><i class="fa fa-circle-o"></i>{{$accreditation_requirement->name}}</a></li>
                  @endforeach
                </ul>
              </li>

              @endforeach
            </ul>
          </li>

          <li><a href="{{url('#')}}"><i class="fa fa-circle-o"></i>Construction</a></li>
          <li><a href="{{url('#')}}"><i class="fa fa-circle-o"></i>EVS</a></li>
          <li><a href="{{url('#')}}"><i class="fa fa-circle-o"></i>BioMed</a></li>
          <li><a href="{{url('#')}}"><i class="fa fa-circle-o"></i>Rounding</a></li>
        @endif


  </ul>
  @endif
@endif



@if(Auth::guard('contractor')->check())
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
</section>
</aside>
