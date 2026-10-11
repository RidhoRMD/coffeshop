<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title') | Dashboard</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/logo.webp') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"></noscript>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets') }}/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets') }}/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets') }}/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets') }}/AdminLTE/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/AdminLTE/custom.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset('assets') }}/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets') }}/AdminLTE/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
       

        <!-- Navbar -->
        <x-navbar />
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        @if(auth()->user()->role == 'admin')
            <x-sidebar />
        @elseif(auth()->user()->role == 'kasir')
            <x-kasir />
        @elseif(auth()->user()->role == 'barista')
            <x-barista />
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    @yield('content')
                    <!-- /.row -->
                    <!-- Main row -->

                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2026 <a href="https://adminlte.io">Raund-Raund</a>.</strong>
            All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        <!-- Custom Logout Confirm Modal -->
        <div class="rr-confirm-overlay" id="rrLogoutModal">
            <div class="rr-confirm-box">
                <div class="rr-confirm-icon"><i class="fas fa-sign-out-alt"></i></div>
                <h4>Yakin mau keluar?</h4>
                <p>Kamu perlu login lagi untuk mengakses dashboard ini.</p>
                <div class="rr-confirm-actions">
                    <button type="button" class="rr-confirm-cancel" onclick="closeLogoutConfirm()">Batal</button>
                    <button type="button" class="rr-confirm-ok" onclick="submitLogout()">Ya, Keluar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Generic Delete Confirm Modal (dipakai ulang untuk semua tombol Hapus) -->
        <div class="rr-confirm-overlay" id="rrGenericConfirm">
            <div class="rr-confirm-box">
                <div class="rr-confirm-icon"><i class="fas fa-trash"></i></div>
                <h4 id="rrGenericConfirmTitle">Hapus data ini?</h4>
                <p id="rrGenericConfirmText">Data yang dihapus tidak bisa dikembalikan.</p>
                <div class="rr-confirm-actions">
                    <button type="button" class="rr-confirm-cancel" onclick="closeGenericConfirm()">Batal</button>
                    <button type="button" class="rr-confirm-ok" id="rrGenericConfirmOk">Ya, Hapus</button>
                </div>
            </div>
        </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/AdminLTE/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets') }}/AdminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets') }}/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('assets') }}/AdminLTE/plugins/moment/moment.min.js"></script>
    <script src="{{ asset('assets') }}/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets') }}/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
    </script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets') }}/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets') }}/AdminLTE/dist/js/adminlte.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets') }}/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <!-- Bahasa Indonesia untuk semua tabel DataTables -->
    <script>
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                search: 'Cari:',
                emptyTable: 'Belum ada data.',
                zeroRecords: 'Data tidak ditemukan.',
                info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                infoEmpty: 'Menampilkan 0 data',
                infoFiltered: '(disaring dari _MAX_ data)',
                paginate: {
                    previous: 'Sebelumnya',
                    next: 'Berikutnya'
                }
            }
        });
    </script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    @yield('js')
    <script>
        function openLogoutConfirm() {
            document.getElementById('rrLogoutModal').classList.add('show');
        }
        function closeLogoutConfirm() {
            document.getElementById('rrLogoutModal').classList.remove('show');
        }
        function submitLogout() {
            document.getElementById('logout-form').submit();
        }
        // Klik di luar box juga nutup modal
        document.getElementById('rrLogoutModal').addEventListener('click', function (e) {
            if (e.target === this) closeLogoutConfirm();
        });
    </script>

     <script>
        let rrConfirmForm = null;
 
        function confirmDeleteForm(formEl, title, text) {
            rrConfirmForm = formEl;
            document.getElementById('rrGenericConfirmTitle').textContent = title || 'Hapus data ini?';
            document.getElementById('rrGenericConfirmText').textContent = text || 'Data yang dihapus tidak bisa dikembalikan.';
            document.getElementById('rrGenericConfirm').classList.add('show');
        }
 
        function closeGenericConfirm() {
            document.getElementById('rrGenericConfirm').classList.remove('show');
            rrConfirmForm = null;
        }
 
        document.getElementById('rrGenericConfirmOk').addEventListener('click', function () {
            if (rrConfirmForm) rrConfirmForm.submit();
        });
 
        document.getElementById('rrGenericConfirm').addEventListener('click', function (e) {
            if (e.target === this) closeGenericConfirm();
        });
    </script>
</body>

</html>