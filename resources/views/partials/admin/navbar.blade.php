<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm sticky-top py-3">
  <div class="container-fluid px-md-5">
    
    <a class="navbar-brand fw-bold text-body d-flex align-items-center gap-2 tracking-tight" href="{{ route('administrator.dashboard') }}">      
      <div class="d-flex flex-column lh-sm">
        <span class="fs-5">Administrator</span>
        <small class="text-muted fw-normal">Content Management System</small>
      </div>
    </a>
    
    <button class="navbar-toggler border-0 shadow-none bg-body p-2 rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-1 mt-3 mt-lg-0 align-items-lg-center">
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-body {{ Request::routeIs('administrator.dashboard') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.dashboard') }}">
                    Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-body {{ Request::is('*menu*') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.menu.index') }}">
                   Menu
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-body {{ Request::is('*article*') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.article.index') }}">
                   Article
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-body {{ Request::is('*banner*') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.banner.index') }}">
                   Banner
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-body {{ Request::is('*gallery*') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.gallery.index') }}">
                   Gallery
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-body {{ Request::is('*message*') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.message.index') }}">
                   Message
                </a>
            </li>
            
            <li class="nav-item">
                 <a class="nav-link px-3 py-2 rounded-3 fw-medium text-body {{ Request::is('*users*') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.users.index') }}">
                   Users
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-body {{ Request::is('*profile*') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.profile.index') }}">
                   Profile
                </a>
            </li>

            <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                <button id="btnDarkModeToggle" class="btn btn-link text-body p-2 rounded-3 text-decoration-none shadow-none border-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: var(--bs-tertiary-bg);">
                    <i id="darkModeIcon" class="bi bi-sun-fill fs-5"></i>
                </button>
            </li>

      </ul>
    </div>
  </div>
</nav>