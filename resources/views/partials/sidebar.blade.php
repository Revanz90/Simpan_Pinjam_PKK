<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="/img/Logo PKK.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">SP-PKK</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('AdminLTE') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                    alt="User Image" />
            </div>
            <div class="info">
                <a href="{{ route('dashboard') }}" class="d-block">Anastasya Rosa Dewani</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                <li class="nav-header">MAIN MENU</li>
                <li class="nav-item {{ request()->routeIs('data_simpanan') ? 'menu-open' : '' }}">
                    <a href="{{ route('data_simpanan') }}" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>Data Simpanan</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('data_pinjaman') ? 'menu-open' : '' }}">
                    <a href="{{ route('data_pinjaman') }}" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>Data Pinjaman</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('data_angsuran') ? 'menu-open' : '' }}">
                    <a href="{{ route('data_angsuran') }}" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>Data Angsuran</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
