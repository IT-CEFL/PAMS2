<style>
  .sub-menu{
    margin: 0 0.9rem !important;
  }
  .micon{
    margin-right:0.5rem !important;
  }
  .menu-margin{
    margin: 0 1rem;
  }
  .sidebar .nav.sub-menu .nav-item .nav-link{
    padding:1rem 3.3rem !important;
  }
  .sidebar-icon-only .nav.sub-menu .nav-item .nav-link{
    padding:1rem !important;
  }
</style>
<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
@if ($user)
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="user-profile">
        <div class="user-image">
            <img src="/images/faces/face28.png">
        </div>
        <div class="user-name">
            {{ $user->name }}
        </div>
        <div class="user-designation">
            {{ $user->email }} <br>
        </div>
    </div>
    
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link menu-margin" href="/dashboard">
              <i class="icon-box menu-icon micon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if ($user->role->RoleName =='Admin')
        <li class="nav-item">
            <a class="nav-link menu-margin" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
                <i class="icon-disc menu-icon micon"></i>
                <span class="menu-title">All Application</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/applications/new">New Application</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/applications/ongoing">Ongoing Application</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/applications/completed">Completed Application</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/applications/rejected">Rejected Application</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/applications/withdrawn">Withdrawn Application</a></li>
                </ul>
            </div>
        </li>
        @endif
        @foreach($user->role->access as $access)
            @if($access->moduleID == '1')
            <li class="nav-item">
                <a class="nav-link menu-margin" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic1">
                    <i class="icon-head micon"></i>
                    <span class="menu-title">Manage Users</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic2">
                    <ul class="nav flex-column sub-menu">
                    <!-- <li class="nav-item"> <a class="nav-link" href="/users/create">Register User</a></li> -->
                        <li class="nav-item"> <a class="nav-link" href="/users">All Users</a></li>
                        <li class="nav-item"> <a class="nav-link" href="/centres">All Centres</a></li>
                        <li class="nav-item"> <a class="nav-link" href="/roles">All Roles</a></li>
                </ul>
                </div>
            </li>
            @endif
            @if($access->moduleID == '2')
            <li class="nav-item">
                <a class="nav-link menu-margin" data-toggle="collapse" href="#ui-basic3" aria-expanded="false" aria-controls="ui-basic">
                    <i class="icon-disc menu-icon micon"></i>
                    <span class="menu-title">Approval Request</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic3">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="/request/new">Incoming Request</a></li>
                        <li class="nav-item"> <a class="nav-link" href="/request/submitted">Submitted Request</a></li>
                        <li class="nav-item"> <a class="nav-link" href="/request/completed">Completed Request</a></li>
                        <li class="nav-item"> <a class="nav-link" href="/request/rejected">Rejected Request</a></li>
                        @if($user->role->RoleName=='Head Of Department')
                            <li class="nav-item"> <a class="nav-link" href="/request/dept">Department Request</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif
            @if($access->moduleID == '3')
            <li class="nav-item">
                <a class="nav-link menu-margin" data-toggle="collapse" href="#ui-basic4" aria-expanded="false" aria-controls="ui-basic">
                    <i class="icon-disc menu-icon micon"></i>
                    <span class="menu-title">Item Request</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic4">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="/applications">New Application</a></li>
                        <li class="nav-item"> <a class="nav-link" href="/myApplications_all">All Applications</a></li>
                        <li class="nav-item"> <a class="nav-link" href="/myApplications_approve">Approved</a></li>
                        <li class="nav-item"> <a class="nav-link" href="/myApplications_rejected">Rejected</a></li>
                    </ul>
                </div>
            </li>
            @endif
            @if($access->moduleID == '4' || $access->moduleID == '6' || $access->moduleID == '7')
            <li class="nav-item">
                <a class="nav-link menu-margin" href="/report">
                    <i class="icon-help menu-icon micon"></i>
                    <span class="menu-title">Reports</span>
                </a>
            </li>
            @endif
        @endforeach
        @if ($user->role->RoleName =='Admin')
        <li class="nav-item">
            <a class="nav-link menu-margin" href="/audit">
              <i class="icon-book micon"></i>
              <span class="menu-title">Activity Log</span>
            </a>
        </li>
        @endif
        @if($access->moduleID == '5')
        <li class="nav-item">
            <a class="nav-link menu-margin" href="/settings">
              <i class="fa fa-wrench micon"></i>
              <span class="menu-title">Settings</span>
            </a>
        </li>
        @endif
    </ul>
</nav>
@endif
