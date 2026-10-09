<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher - Meja {{ $meja->nomor_meja }}</title>
     <link rel="icon" type="image/png" href="{{ asset('images/logo.webp') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark: #291C0E;
            --brown: #6E473B;
            --tan: #A78D78;
            --grey-beige: #BEB5A9;
            --cream: #E1D4C2;
            --bg: #F8F7F4;
            --white: #FFFFFF;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: var(--dark); }

        /* NAVBAR - SAMA SEPERTI RIWAYAT */
        .navbar {
            background: rgba(26, 18, 11, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            color: var(--cream);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 32px;
            height: 68px;
            position: sticky;
            top: 0;
            z-index: 25;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            gap: 20px;
        }
        .navbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-shrink: 0;
        }
        .table-badge {
            background: rgba(255,255,255,0.08);
            padding: 8px 16px;
            border-radius: 100px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--cream);
            border: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }
        .navbar-menu {
            display: flex;
            gap: 32px;
            list-style: none;
            flex-shrink: 0;
            margin-right: 17px;
        }
        
        .navbar-menu a {
            color: var(--grey-beige);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 10px 0;
            position: relative;
            transition: color 0.3s ease;
        }
        .navbar-menu a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--tan);
            transition: width 0.3s ease;
        }
        .navbar-menu a.active, .navbar-menu a:hover {
            color: var(--white);
        }
        .navbar-menu a.active::after, .navbar-menu a:hover::after {
            width: 100%;
        }
        .navbar-toggle {
            display: none;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: none;
            background: rgba(255,255,255,0.08);
            color: var(--cream);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
        }
        .navbar-toggle:hover { background: rgba(255,255,255,0.16); }

        main { max-width: 500px; margin: 0 auto; padding: 24px; }
        h2 { font-family: 'Poppins', sans-serif; margin-bottom: 20px; }
        .alert-error { background: #f8d7da; color: #721c24; padding: 12px; border-radius: 10px; margin-bottom: 16px; font-size: 13px; }
        .alert-success { background: #d4edda; color: #155724; padding: 12px; border-radius: 10px; margin-bottom: 16px; font-size: 13px; }
        .voucher-card {
            background: var(--white);
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 16px;
            box-shadow: 0 4px 20px rgba(41,28,14,0.04);
            border-left: 5px solid var(--brown);
        }
        .voucher-card.aktif { border-left-color: #2e7d32; background: #f4faf4; }
        .voucher-kode {
            display: inline-block;
            background: var(--dark);
            color: #fff;
            padding: 4px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .voucher-nama { font-weight: 600; font-size: 15px; margin-bottom: 4px; }
        .voucher-detail { font-size: 12.5px; color: #777; line-height: 1.6; margin-bottom: 12px; }
        .btn-full {
            width: 100%;
            background: var(--dark);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            font-size: 13.5px;
            cursor: pointer;
        }
        .btn-full:disabled { opacity: 0.5; cursor: not-allowed; }
        .badge-aktif {
            display: inline-block;
            background: #2e7d32;
            color: #fff;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
        }
        .btn-outline {
            width: 100%;
            background: transparent;
            color: var(--brown);
            border: 1.5px solid #ddd;
            border-radius: 14px;
            padding: 14px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 10px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: block;
        }
        .kosong { text-align: center; color: #999; font-size: 13.5px; padding: 40px 0; }

        @media (max-width: 640px) {
            .navbar { padding: 0 16px; gap: 10px; height: 60px; position: relative; }
            .navbar-left { gap: 10px; }
            .navbar-toggle { display: flex; }
            .navbar-menu {
                display: none;
                position: absolute;
                top: 60px;
                left: 0;
                right: 0;
                flex-direction: column;
                gap: 0;
                background: var(--dark);
                padding: 8px 0;
                box-shadow: 0 20px 50px rgba(0,0,0,0.25);
                z-index: 24;
            }
            .navbar-menu.show { display: flex; }
            .navbar-menu li { width: 100%; }
            .navbar-menu a { display: block; padding: 14px 20px; font-size: 13px; }
            .navbar-menu a::after { display: none; }
            .table-badge { padding: 5px 10px; font-size: 11px; }
        }
    </style>
</head>
<body>

    <!-- ===== NAVBAR (SAMA SEPERTI RIWAYAT) ===== -->
    <nav class="navbar">
        <div class="navbar-left">
            <img src="{{ asset('images/logo.webp') }}" alt="Raund-Raund" style="height:36px; width:auto;">
            <div class="table-badge">Meja {{ $meja->nomor_meja }}</div>
        </div>

        <ul class="navbar-menu" id="navbar-menu">
            <li><a href="{{ route('order.index', $meja->kode_qr) }}">Menu</a></li>
            <li><a href="{{ route('order.voucher.list', $meja->kode_qr) }}" class="active">Voucher</a></li>
            <li><a href="{{ route('order.pesanan', $meja->kode_qr) }}">Pesanan</a></li>
            <li><a href="{{ route('order.riwayat', $meja->kode_qr) }}">Riwayat</a></li>
        </ul>

        <button type="button" class="navbar-toggle" id="navbar-toggle" onclick="toggleNavbarMenu()" aria-label="Buka menu navigasi">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
    </nav>

    <main>
        <h2>Voucher Tersedia</h2>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @forelse($vouchers as $v)
            @php $sedangDipakai = $voucherAktifId == $v->id; @endphp
            <div class="voucher-card {{ $sedangDipakai ? 'aktif' : '' }}">
                <div class="voucher-kode">{{ $v->kode }}</div>
                <div class="voucher-nama">{{ $v->nama_voucher }}</div>
                <div class="voucher-detail">
                    Diskon {{ $v->tipe_diskon === 'persen' ? $v->nilai_diskon.'%' : 'Rp '.number_format($v->nilai_diskon,0,',','.') }}
                    @if($v->minimal_belanja > 0)
                        &middot; Min. belanja Rp {{ number_format($v->minimal_belanja,0,',','.') }}
                    @endif
                    <br>Berlaku sampai {{ $v->tanggal_expired->format('d/m/Y') }}
                </div>

                @if($sedangDipakai)
                    <span class="badge-aktif">Sedang Digunakan</span>
                @else
                    <form action="{{ route('order.voucher.apply', $meja->kode_qr) }}" method="POST">
                        @csrf
                        <input type="hidden" name="kode" value="{{ $v->kode }}">
                        <button type="submit" class="btn-full">Gunakan Voucher</button>
                    </form>
                @endif
            </div>
        @empty
            <div class="kosong">Belum ada voucher yang tersedia saat ini.</div>
        @endforelse

        <a href="{{ route('order.checkout.page', $meja->kode_qr) }}" class="btn-outline">Kembali ke Checkout</a>
    </main>

    <script>
        function toggleNavbarMenu() {
            document.getElementById('navbar-menu').classList.toggle('show');
        }
        document.addEventListener('click', function (e) {
            const menu = document.getElementById('navbar-menu');
            const toggle = document.getElementById('navbar-toggle');
            if (!menu.classList.contains('show')) return;
            if (menu.contains(e.target) || toggle.contains(e.target)) return;
            menu.classList.remove('show');
        });
    </script>

</body>
</html>