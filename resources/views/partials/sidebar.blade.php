 <!-- Sidebar -->
 <div class="sidebar" data-background-color="dark">
     <div class="sidebar-logo">
         <!-- Logo Header -->
         <div class="logo-header" data-background-color="dark">
             <a href="index.html" class="logo">
                 <img src="/assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
             </a>
             <div class="nav-toggle">
                 <button class="btn btn-toggle toggle-sidebar">
                     <i class="gg-menu-right"></i>
                 </button>
                 <button class="btn btn-toggle sidenav-toggler">
                     <i class="gg-menu-left"></i>
                 </button>
             </div>
             <button class="topbar-toggler more">
                 <i class="gg-more-vertical-alt"></i>
             </button>
         </div>
         <!-- End Logo Header -->
     </div>
     <div class="sidebar-wrapper scrollbar scrollbar-inner">
         <div class="sidebar-content">
             <ul class="nav nav-secondary">

                 <li class="nav-item {{ setActive('dashboard') }}">
                     <a href="{{ route('dashboard') }}">
                         <i class="fas fa-home"></i>
                         <p>Dashboard</p>
                     </a>
                 </li>
                 <li class="nav-item {{ setActive('users.*') }}">
                     <a href="{{ route('users.index') }}">
                         <i class="fas fa-users"></i>
                         <p>User Management</p>
                     </a>
                 </li>
                 <li class="nav-item {{ setActive('procrument-request.*') }}">
                     <a href="{{ route('procrument-request.index') }}">
                         <i class="fas fa-file-signature"></i>
                         <p>Pengajuan Pengadaan</p>
                     </a>
                 </li>
                 <li class="nav-item {{ setActive('suppliers.*') }}">
                     <a href="{{ route('suppliers.index') }}">
                         <i class="fas fa-archive"></i>
                         <p>Supplier</p>
                     </a>
                 </li>
                 <li class="nav-item {{ setActive('supplier_evaluation.*') }}">
                     <a href="{{ route('supplier_evaluation.index') }}">
                         <i class="
fas fa-clipboard-list"></i>
                         <p>Supplier Evaluasi</p>
                     </a>
                 </li>
                 <li class="nav-section">
                     <span class="sidebar-mini-icon">
                         <i class="fa fa-cog"></i>
                     </span>
                     <h4 class="text-section">Pengaturan</h4>
                 </li>
                 <li class="nav-item {{ setActive('settings.*') }}">
                     <a href="{{ route('settings.index') }}">
                         <i class="fas fa-cogs"></i>
                         <p>Setting</p>
                     </a>
                 </li>
                 <li class="nav-item {{ setActive('profile.*') }}">
                     <a href="{{ route('profile.edit') }}">
                         <i class="fas fa-user"></i>
                         <p>Setting</p>
                     </a>
                 </li>

             </ul>
         </div>
     </div>
 </div>
 <!-- End Sidebar -->
