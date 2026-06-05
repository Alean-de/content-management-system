<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
  <div class="container-fluid px-md-5">
    
    <a class="navbar-brand fw-bold text-dark d-flex align-items-center gap-2 tracking-tight" href="#">
      <div class="bg-primary rounded-3 text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
        <i class="bi bi-shield-lock-fill small"></i>
      </div>
      <span>Addawn<span class="text-primary">Admin</span></span>
    </a>
    
    <button class="navbar-toggler border-0 shadow-none bg-light p-2 rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-1 mt-3 mt-lg-0">
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-secondary {{ Request::routeIs('administrator.dashboard') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.dashboard') }}">
                   <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-secondary {{ Request::is('*menu*') ? 'active bg-primary bg-opacity-10 text-primary fw-bold' : '' }}" 
                   href="{{ route('administrator.menu.') }}">
                   <i class="bi bi-egg-fried me-1"></i> Menu
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-secondary {{ Request::is('*article*') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.article.') }}">
                   <i class="bi bi-journal-text me-1"></i> Article
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-secondary {{ Request::is('*banner*') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.banner.') }}">
                   <i class="bi bi-images me-1"></i> Banner
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-secondary {{ Request::is('*gallery*') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.gallery.') }}">
                   <i class="bi bi-collection me-1"></i> Gallery
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-secondary {{ Request::is('*message*') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.message.') }}">
                   <i class="bi bi-envelope me-1"></i> Message
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 fw-medium text-secondary {{ Request::is('*profile*') ? 'active bg-primary bg-opacity-10 text-primary' : '' }}" 
                   href="{{ route('administrator.profile.') }}">
                   <i class="bi bi-person-circle me-1"></i> Profile
                </a>
            </li>

      </ul>
    </div>
  </div>
</nav>