<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('barista.dashboard') }}" class="brand-link">
        <img src="{{ asset('images/logo.webp') }}" alt="Raund-Raund"
            class="brand-image img-circle elevation-3" style="opacity: .9">
        <span class="brand-text font-weight-light">Barista</span>
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
                    <a href="{{ route('barista.dashboard') }}"
                        class="nav-link {{ request()->routeIs('barista.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('barista.pesanan.index') }}"
                            class="nav-link {{ request()->routeIs('barista.pesanan.index') || request()->routeIs('barista.pesanan.status') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-mug-hot"></i>
                        <p>Pesanan Masuk</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('barista.menu.index') }}"
                        class="nav-link {{ request()->routeIs('barista.menu.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Status Menu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('barista.pesanan.riwayat') }}"
                        class="nav-link {{ request()->routeIs('barista.pesanan.riwayat') ? 'active' : '' }}">
                        <i class="fas fa-history nav-icon"></i>
                        <p>Riwayat Hari Ini</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->

    <!-- Profil & Logout — nempel di bawah, class sidebar-footer-pinned
         dikontrol lewat custom.css (sama seperti Admin & Kasir) -->
    <div class="sidebar-footer-pinned">
        <ul class="nav nav-pills nav-sidebar flex-column mb-3">
            <li class="nav-item">
                <a href="{{ route('barista.profil') }}" class="nav-link {{ request()->routeIs('barista.profil') ? 'active' : '' }}">
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