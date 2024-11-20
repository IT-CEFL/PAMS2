<style>
  .glitch{
    position: relative;
    display: block;
    animation: glitch 0.5s infinite;
  }
  .hitam{
    background-color:black !important;
  }

  @keyframes glitch {
    0% {
      transform:translate(0);
    }
    25% {
      transform:translate(-5px,5px);
    }
    50% {
      transform:translate(5px,-5px);
    }
    75% {
      transform:translate(-5px,5px);
    }
    100% {
      transform:translate(0);
    }
  }
  .btn-primary {
      background-color: #216ade;
      border-color: #216ade;
    }
    
    .btn-primary:hover {
      background-color: #1a54b0;
      border-color: #1a54b0;
    }
    .btn-primary:disabled{
      background-color: #6a95d9;
      border-color: #6a95d9;
    }
</style>
@include('sweetalert::alert')
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="/dashboard">
          <strong style="color: white;font-size: 20px;">PAYMENT APPROVAL<br>MANAGEMENT SYSTEM</strong>
        </a>
        <a class="navbar-brand brand-logo-mini" href="/dashboard">
          <strong style="color: white; font-size:80%">PAMS</strong>
        </a>

      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" title="toggleMenu" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
       
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown d-flex mr-4 ">
            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Settings</p>
              <a href="/profile" class="dropdown-item preview-item">               
                  <i class="icon-head"></i> Profile
              </a>
              <a href="/password" class="dropdown-item preview-item">
                  <i class="icon-cog"></i> Change Password
              </a>
              <a href="/logout" class="dropdown-item preview-item">
                  <i class="icon-inbox"></i> Logout
              </a>
            </div>
          </li>
         
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" title="toggleMenu" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>