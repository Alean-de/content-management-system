<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Admin</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- MENGGUNAKAN ms-auto AGAR MENU BERGESER KE KANAN DENGAN RAPI -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('administrator.dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('administrator.menu.') }}">Menu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('administrator.article.') }}">Article</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('administrator.banner.') }}">Banner</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('administrator.gallery.') }}">Gallery</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('administrator.message.') }}">Message</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('administrator.profile.') }}">Profile</a>
            </li>
      </ul>
    </div>
  </div>
</nav>
