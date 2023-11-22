<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ asset('/dashboard') }}" class="brand-link">
    <img src="{{ asset('/') }}dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">UKRIDA PSIKOTES</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 ">
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    
    <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
          with font-awesome or any other icon font library -->
      <li class="nav-header"> DASHBOARD</li>
      <li class="nav-item">
        <a href="{{ asset('/dashboard') }}" class="nav-link">
          <i class="nav-icon fas fa-home"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('/profile') }}" class="nav-link">
          <i class="nav-icon fas fa-user-edit"></i>
          <p>
            Profile
          </p>
        </a>
      </li>
      <li class="nav-header"> Data Tampilan </li>
      <li class="nav-item">
        <a href="{{ asset('/pagecontent') }}" class="nav-link">
          <i class="nav-icon fas fa-file"></i>
          <p>
            Page Content
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('/pageevent') }}" class="nav-link">
          <i class="nav-icon fas fa-calendar"></i> 
          <p>
            Page Event
          </p>
        </a>
      </li>
      <li class="nav-header"> Data Base Psikotes</li>
      <li class="nav-item">
        <a href="{{ asset('/userdata') }}" class="nav-link">
          <i class="nav-icon fas fa-user"></i>
          <p>
            User Data
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('/pagecategory') }}" class="nav-link">
          <i class="nav-icon fas fa-folder"></i>
          <p>
            Category
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('/pagequestion') }}" class="nav-link">
          <i class="nav-icon fas fa-question"></i>
          <p>
            Questions
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('/pageanswer') }}" class="nav-link">
          <i class="nav-icon fas fa-comments"></i>
          <p>
            Answer
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('pageclassification') }}" class="nav-link">
          <i class="nav-icon fas fa-tag"></i>
          <p>
            Classification
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('pagehistory') }}" class="nav-link">
          <i class="nav-icon fas fa-history"></i>
          <p>
            History
          </p>
        </a>
      </li>      
    </ul>
  </nav>
    <!-- /.sidebar-menu -->
  </div>
</aside>