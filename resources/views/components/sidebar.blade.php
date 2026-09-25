<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('images/logo.webp') }}" alt="Raund-Raund"
            class="brand-image img-circle elevation-3" style="opacity: .9">
        <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img src="https://api.dicebear.com/9.x/notionists/svg?seed={{ urlencode(auth()->user()->name) }}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.kategori-menu.index') }}"
                        class="nav-link {{ request()->routeIs('admin.kategori-menu.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Kategori Menu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.menu.index') }}"
                        class="nav-link {{ request()->routeIs('admin.menu.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-mug-hot"></i>
                        <p>Menu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.meja.index') }}"
                        class="nav-link {{ request()->routeIs('admin.meja.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chair"></i>
                        <p>Meja</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pesanan.index') }}"
                        class="nav-link {{ request()->routeIs('admin.pesanan.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Pesanan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pegawai.index') }}"
                        class="nav-link {{ request()->routeIs('admin.pegawai.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Kelola Pegawai</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.voucher.index') }}" class="nav-link {{ request()->routeIs('admin.voucher.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>Voucher</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.laporan') }}" class="nav-link {{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Laporan Penjualan</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->

    <!-- Profil & Logout, nempel di bawah — class "sidebar-footer-pinned" dipakai
         custom.css untuk mengontrol sendiri kapan teksnya disembunyikan/dimunculkan -->
    <div class="sidebar-footer-pinned">
        <ul class="nav nav-pills nav-sidebar flex-column mb-3">
            <li class="nav-item">
                <a href="{{ route('admin.profil') }}" class="nav-link {{ request()->routeIs('admin.profil') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Profil</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link logout-link"
                    onclick="event.preventDefault(); openLogoutConfirm();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</aside>