<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('kasir.dashboard') }}" class="brand-link">
        <img src="{{ asset('images/logo.webp') }}" alt="Raund-Raund"
            class="brand-image img-circle elevation-3" style="opacity: .9">
        <span class="brand-text font-weight-light">Kasir</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
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
                    <a href="{{ route('kasir.dashboard') }}"
                        class="nav-link {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kasir.pesanan.create') }}"
                        class="nav-link {{ request()->routeIs('kasir.pesanan.create') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>Pesanan Baru</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kasir.pesanan.index') }}"
                       class="nav-link {{ request()->routeIs('kasir.pesanan.index', 'kasir.pesanan.show') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Pesanan</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->

    <!-- Profil, Tutup Shift & Logout — nempel di bawah, class sidebar-footer-pinned
         dikontrol lewat custom.css (sama seperti Admin) -->
    <div class="sidebar-footer-pinned">
        <ul class="nav nav-pills nav-sidebar flex-column mb-3">
            <li class="nav-item">
                <a href="{{ route('kasir.profil') }}" class="nav-link {{ request()->routeIs('kasir.profil') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Profil</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kasir.shift.tutup') }}" class="nav-link">
                    <i class="nav-icon fas fa-door-closed"></i>
                    <p>Tutup Shift</p>
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