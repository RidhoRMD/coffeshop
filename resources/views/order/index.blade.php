<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Meja {{ $meja->nomor_meja }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.webp') }}">
       <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($promo) && $promo && !empty($promo->gambar))
    <link rel="preload" as="image" href="{{ asset('uploads/promo/'.$promo->gambar) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark: #1A120B;
            --brown: #6E473B;
            --brown-light: #8A5E50;
            --tan: #A78D78;
            --grey-beige: #BEB5A9;
            --cream: #E1D4C2;
            --bg: #F3F1EE;
            --white: #FFFFFF;
            --shadow-sm: 0 4px 12px rgba(26, 18, 11, 0.04);
            --shadow-md: 0 10px 30px rgba(26, 18, 11, 0.08);
            --shadow-lg: 0 20px 50px rgba(26, 18, 11, 0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }
        html {
            scrollbar-width: none;
        }
        html::-webkit-scrollbar {
            width: 0;
            background: transparent;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--dark);
            padding-bottom: 120px;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        /* NAVBAR (Glassmorphism Modern) - SAMA SEPERTI RIWAYAT */
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

        .navbar-logo {
            font-family: 'Poppins', sans-serif;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--white);
        }

        .navbar-welcome {
            font-size: 13px;
            color: var(--grey-beige);
            font-weight: 400;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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

        /* KATEGORI SCROLL */
        .kategori-scroll {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding: 20px 32px;
            background: var(--white);
            position: sticky;
            top: 68px;
            z-index: 19;
            border-bottom: 1px solid #eee;
            scrollbar-width: none;
        }
        .kategori-scroll::-webkit-scrollbar { display: none; }

        .kategori-chip {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 16px 8px 8px;
            border-radius: 100px;
            border: 1px solid transparent;
            background: var(--bg);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .kategori-chip .ikon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: var(--brown);
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }

        .kategori-chip:hover {
            border-color: var(--tan);
            background: #fff;
        }

        .kategori-chip.active {
            background: var(--dark);
            border-color: var(--dark);
            box-shadow: 0 8px 20px rgba(26, 18, 11, 0.2);
        }

        .kategori-chip.active .ikon {
            background: var(--brown);
            color: var(--white);
        }

        .kategori-chip span.label {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--dark);
            white-space: nowrap;
        }

        .kategori-chip.active span.label {
            color: var(--white);
        }

        /* ===== SEARCH BAR ===== */
        .kategori-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 32px;
            background: var(--white);
            position: sticky;
            top: 68px;
            z-index: 19;
            border-bottom: 1px solid #eee;
        }

        .kategori-bar .kategori-scroll {
            position: static;
            padding: 0;
            border-bottom: none;
            flex: 1;
            min-width: 0;
        }

        .search-toggle-btn {
            flex-shrink: 0;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid #eee;
            background: var(--bg);
            color: var(--brown);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            transition: 0.2s;
        }
        .search-toggle-btn:hover,
        .search-toggle-btn.active {
            background: var(--dark);
            color: #fff;
        }

        .search-bar-wrap {
            display: none;
            padding: 0 32px 16px;
            background: var(--white);
            position: sticky;
            top: 122px;
            z-index: 18;
        }
        .search-bar-wrap.show { display: block; }

        .search-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1.5px solid #eee;
            font-size: 13.5px;
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--dark);
        }
        .search-input:focus {
            outline: none;
            border-color: var(--tan);
        }

        /* PAGE LAYOUT (full width — sidebar dihapus) */
        .page-shell {
            max-width: 1000px;
            margin: 0 auto;
            padding: 32px;
        }

        main.content { max-width: 100%; }

        /* PROMO BANNER */
        .promo-banner {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            min-height: 300px;
            display: flex;
            align-items: flex-end;
            padding: 32px;
            color: var(--white);
            background:
                linear-gradient(0deg, rgba(15, 10, 6, 0.82) 0%, rgba(15, 10, 6, 0.25) 55%, rgba(15, 10, 6, 0.05) 100%),
                linear-gradient(135deg, var(--brown) 0%, var(--dark) 100%);
            background-size: cover;
            background-position: center;
            box-shadow: var(--shadow-md);
        }

        @if(isset($promo) && $promo && !empty($promo->gambar))
        .promo-banner {
            background:
                linear-gradient(0deg, rgba(15, 10, 6, 0.82) 0%, rgba(15, 10, 6, 0.25) 55%, rgba(15, 10, 6, 0.05) 100%),
                url('{{ asset('uploads/promo/'.$promo->gambar) }}');
            background-size: cover;
            background-position: center;
        }
        @endif

        .promo-content { max-width: 480px; }

        .promo-content h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 32px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 10px;
        }

        .promo-content p {
            font-size: 13.5px;
            color: var(--cream);
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .promo-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--white);
            color: var(--dark);
            border: none;
            padding: 12px 22px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .promo-cta:hover { transform: translateY(-2px); }

        .kategori-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 32px 0 24px;
        }

        .kategori-judul {
            font-family: 'Poppins', sans-serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--dark);
            position: relative;
            padding-left: 16px;
        }

        .kategori-judul::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 24px;
            background: var(--brown);
            border-radius: 10px;
        }

        .kategori-count {
            font-size: 12px;
            color: var(--brown);
            background: rgba(110, 71, 59, 0.08);
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* GRID MENU & CARD */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 24px;
        }

        .menu-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.02);
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .menu-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
        }

        .menu-card .thumb-wrap { position: relative; }

        .menu-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .menu-card:hover img {
            transform: scale(1.05);
        }

        .menu-card .no-img {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, var(--cream) 0%, var(--bg) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .rating-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--white);
            padding: 5px 10px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 700;
            color: var(--dark);
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .rating-badge .star { color: #E0A527; }

        .menu-info { 
            padding: 18px; 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
        }

        .menu-info h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 6px;
            line-height: 1.4;
            letter-spacing: -0.3px;
        }

        .menu-info .deskripsi {
            font-size: 12.5px;
            color: #888;
            margin-bottom: 16px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }

        .menu-info .harga {
            color: var(--brown);
            font-weight: 700;
            font-size: 17px;
            margin-bottom: 16px;
            font-family: 'Poppins', sans-serif;
        }

        .btn-tambah {
            width: 100%;
            background: var(--dark);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 12px 0;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-tambah:hover {
            background: var(--brown);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(110, 71, 59, 0.3);
        }

        /* KONTROL JUMLAH MENU DI KARTU */
        .qty-menu-control {
            width: 100%;
            background: var(--bg);
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 6px;
            display: none;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .qty-menu-control.show {
            display: flex;
        }

        .qty-menu-control button {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 10px;
            background: var(--white);
            color: var(--dark);
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: 0.15s;
            flex-shrink: 0;
        }

        .qty-menu-control button:hover {
            background: var(--dark);
            color: var(--white);
        }

        .qty-menu-control button:active {
            transform: scale(0.9);
        }

        .qty-number-input {
            flex: 1;
            text-align: center;
            font-size: 14px;
            font-weight: 700;
            color: var(--dark);
            border: none;
            background: transparent;
            font-family: 'Poppins', sans-serif;
            min-width: 0;
            -moz-appearance: textfield;
        }
        .qty-number-input::-webkit-outer-spin-button,
        .qty-number-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* FLOATING CART BUTTON (pengganti sidebar Keranjang) */
        .fab-cart {
            position: fixed;
            bottom: 26px;
            right: 26px;
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: var(--dark);
            color: #fff;
            border: none;
            box-shadow: var(--shadow-lg);
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 30;
            transition: transform 0.2s ease, background 0.2s ease;
        }
        .fab-cart:hover { transform: scale(1.06); background: var(--brown); }
        .fab-cart-badge {
            position: absolute;
            top: -3px;
            right: -3px;
            background: #E53935;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            min-width: 21px;
            height: 21px;
            border-radius: 11px;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            border: 2.5px solid var(--bg);
        }

        @media (max-width: 640px) {
            .fab-cart { bottom: 20px; right: 20px; width: 52px; height: 52px; font-size: 19px; }
        }

        /* MODAL UMUM (Premium Bottom Sheet) */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(26, 18, 11, 0.7);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: none;
            align-items: flex-end;
            justify-content: center;
            z-index: 50;
        }
        .modal-overlay.show { display: flex; }

        .modal-box {
            background: var(--white);
            width: 100%;
            max-width: 520px;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 32px 32px 0 0;
            padding: 28px;
            animation: modalUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .modal-drag-handle {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: grab;
            touch-action: none;
            z-index: 5;
        }
        .modal-drag-handle:active {
            cursor: grabbing;
        }
        .modal-drag-bar {
            width: 40px;
            height: 4px;
            background: #ddd;
            border-radius: 2px;
            pointer-events: none;
        }

        @keyframes modalUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }

        .modal-box h3 {
            font-family: 'Poppins', sans-serif;
            margin: 10px 0 24px 0;
            color: var(--dark);
            font-size: 24px;
            font-weight: 700;
        }

        .opsi-group { margin-bottom: 28px; }
        .opsi-group label.judul {
            display: block;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 12px;
            color: var(--brown);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .opsi-pill {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 100px;
            border: 1.5px solid #eee;
            background: var(--bg);
            font-size: 13px;
            margin-right: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            font-weight: 500;
            color: var(--dark);
            transition: 0.2s;
        }
        .opsi-pill:hover { border-color: var(--tan); transform: translateY(-2px); }
        .opsi-pill.active {
            background: var(--dark);
            border-color: var(--dark);
            color: #fff;
            box-shadow: 0 5px 15px rgba(26, 18, 11, 0.2);
        }

        .btn-full {
            width: 100%;
            background: var(--dark);
            color: #fff;
            border: none;
            border-radius: 16px;
            padding: 18px;
            font-weight: 700;
            font-size: 15px;
            margin-top: 16px;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-full:hover { background: var(--brown); box-shadow: 0 10px 20px rgba(110, 71, 59, 0.3); }
        
        .btn-outline {
            width: 100%;
            background: transparent;
            color: var(--brown);
            border: 1.5px solid #ddd;
            border-radius: 16px;
            padding: 16px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 12px;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-outline:hover { background: var(--bg); border-color: var(--brown); }

        /* Modal alert (pengganti alert() bawaan browser) */
        .alert-icon-wrap {
            width: 56px; height: 56px; border-radius: 50%;
            background: rgba(224,165,39,0.12); color: #E0A527;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px; font-size: 22px;
        }
        .modal-box.alert-box { max-width: 380px; text-align: center; }
        .modal-box.alert-box h3 { font-size: 18px; margin-bottom: 8px; }
        .modal-box.alert-box p { color: #888; font-size: 13px; line-height: 1.6; margin-bottom: 4px; }
        .modal-box.alert-box .btn-full { margin-top: 20px; }

        /* CART ITEMS */
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 0;
            border-bottom: 1px solid #f0ede9;
        }
        .cart-item:last-child { border-bottom: none; }
        
        .cart-item .nama { font-size: 15px; font-weight: 600; }
        .cart-item .ket { font-size: 12px; color: #999; margin-top: 4px; font-style: italic; }
        
        .qty-control { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            background: var(--bg);
            padding: 8px 12px;
            border-radius: 100px;
            border: 1px solid #eee;
        }
        .qty-control button {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: var(--white);
            color: var(--dark);
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.1s;
            flex-shrink: 0;
        }
        .qty-control button:active { transform: scale(0.9); }
        .qty-control input {
            width: 38px;
            font-size: 15px;
            font-weight: 700;
            text-align: center;
            border: none;
            background: transparent;
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            -moz-appearance: textfield;
        }
        .qty-control input::-webkit-outer-spin-button,
        .qty-control input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .cart-total-row {
            display: flex;
            justify-content: space-between;
            font-weight: 800;
            font-size: 20px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 2px dashed #ddd;
            color: var(--dark);
            font-family: 'Poppins', sans-serif;
        }

        /* ===== FIX TAMPILAN MOBILE ===== */
        @media (max-width: 640px) {
            .navbar-welcome {
                display: none;
            }
            .navbar {
                padding: 0 16px;
                gap: 10px;
                height: 60px;
                position: relative;
            }
            .navbar-left {
                gap: 10px;
            }
            .navbar-toggle {
                display: flex;
            }
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
                box-shadow: var(--shadow-lg);
                z-index: 24;
            }
            .navbar-menu.show {
                display: flex;
            }
            .navbar-menu li {
                width: 100%;
            }
            .navbar-menu a {
                display: block;
                padding: 14px 20px;
                font-size: 13.5px;
            }
            .navbar-menu a::after {
                display: none;
            }
            .navbar-logo {
                font-size: 18px;
            }
            .table-badge {
                padding: 5px 10px;
                font-size: 11px;
            }
            .kategori-scroll {
                padding: 14px 16px;
                top: 60px;
            }
            .page-shell {
                padding: 16px;
                gap: 16px;
            }
            .promo-banner {
                min-height: 180px;
                padding: 20px;
                border-radius: 16px;
            }
            .promo-content h1 {
                font-size: 22px;
            }
            .promo-content p {
                font-size: 12.5px;
            }

            /* Tambahan: card menu 2 kolom + search bar mobile */
            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            .menu-card img,
            .menu-card .no-img {
                height: 110px;
            }
            .menu-info {
                padding: 12px;
            }
            .menu-info h3 {
                font-size: 13px;
                margin-bottom: 4px;
                display: -webkit-box;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .menu-info .deskripsi {
                display: none;
            }
            .menu-info .harga {
                font-size: 13px;
                margin-bottom: 10px;
            }
            .btn-tambah {
                padding: 9px 0;
                font-size: 11px;
            }
            .kategori-bar {
                padding: 14px 16px;
            }
        }
    </style>
</head>
<body>

    <!-- ===== NAVBAR (DIUBAH - SAMA SEPERTI RIWAYAT) ===== -->
    <nav class="navbar">
        <div class="navbar-left">
            <img src="{{ asset('images/logo.webp') }}" alt="Raund-Raund" width="36" height="36" style="height:36px; width:auto;">
            <div class="table-badge">Meja {{ $meja->nomor_meja }}</div>
        </div>

        <ul class="navbar-menu" id="navbar-menu">
            <li><a href="#" class="active">Menu</a></li>
            <li><a href="{{ route('order.voucher.list', $meja->kode_qr) }}">Voucher</a></li>
            <li><a href="{{ route('order.pesanan', $meja->kode_qr) }}">Pesanan</a></li>
            <li><a href="{{ route('order.riwayat', $meja->kode_qr) }}">Riwayat</a></li>
        </ul>

        <button type="button" class="navbar-toggle" id="navbar-toggle" onclick="toggleNavbarMenu()" aria-label="Buka menu navigasi">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
    </nav>

    <div class="kategori-bar">
        <div class="kategori-scroll" id="kategori-scroll">
            <div class="kategori-chip active" data-kategori="all">
                <div class="ikon">A</div>
                <span class="label">Semua</span>
            </div>
            @foreach($kategori as $kat)
                @if($kat->menu->count())
                    <div class="kategori-chip" data-kategori="{{ $kat->id }}">
                        <div class="ikon">{{ strtoupper(substr($kat->nama_kategori, 0, 1)) }}</div>
                        <span class="label">{{ $kat->nama_kategori }}</span>
                    </div>
                @endif
            @endforeach
        </div>
    
        {{-- <button type="button" class="search-toggle-btn" id="search-toggle-btn" onclick="toggleSearchBar()">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button> --}}
    </div>

    <div class="search-bar-wrap" id="search-bar-wrap">
        <input type="text" class="search-input" id="search-input" placeholder="Cari menu..." oninput="filterMenuBySearch(this.value)">
    </div>

    <div class="page-shell">
        <main class="content">

            <div class="promo-banner">
                <div class="promo-content">
                    <h1>Selamat Datang di</h1>
                    <h1>Raund-Raund</h1>
                    <p>Nikmati menu favorit kamu, dipesan langsung dari meja tanpa perlu antre di kasir.</p>
                   
                </div>
            </div>

                    @if($rekomendasi->count())
                    <div class="rekomendasi-section" data-kategori-section="rekomendasi">
                        <div class="kategori-header">
                            <div class="kategori-judul">Rekomendasi Untuk Kamu</div>
                            <div class="kategori-count">
                                {{ $rekomendasi->count() }} Menu
                            </div>
                        </div>

                        <div class="menu-grid">
                            @foreach($rekomendasi as $m)
                                <div class="menu-card">
                                    <div class="thumb-wrap">
                                        @if($m->gambar)
                                            <img src="{{ asset('uploads/menu/'.$m->gambar) }}"
                                                alt="{{ $m->nama_menu }}"
                                                width="220" height="180"
                                                loading="lazy" decoding="async">
                                        @else
                                            <div class="no-img">No Image</div>
                                        @endif

                                        @if($m->ratings_count > 0)
                                            <div class="rating-badge">
                                                <span class="star">&#9733;</span> {{ number_format($m->ratings_avg_bintang, 1) }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="menu-info">
                                        <h3>{{ $m->nama_menu }}</h3>

                                        @if($m->deskripsi)
                                            <div class="deskripsi">
                                                {{ $m->deskripsi }}
                                            </div>
                                        @endif

                                        <div class="harga">
                                            Rp {{ number_format($m->harga, 0, ',', '.') }}
                                        </div>

                                       <div class="menu-action">
                                        <button
                                            type="button"
                                            class="btn-tambah"
                                            data-id="{{ $m->id }}"
                                            data-nama="{{ $m->nama_menu }}"
                                            data-harga="{{ $m->harga }}"
                                            data-stok="{{ $m->stok }}"
                                            data-kustom="{{ $m->kategori->perlu_kustomisasi ? '1' : '0' }}"
                                        >
                                            Tambah
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            @foreach($kategori as $kat)
                @if($kat->menu->count())
                    <div class="kategori-section" data-kategori-section="{{ $kat->id }}">
                        <div class="kategori-header">
                            <div class="kategori-judul">{{ $kat->nama_kategori }}</div>
                            <div class="kategori-count">{{ $kat->menu->count() }} Menu</div>
                        </div>

                        

                        <div class="menu-grid">
                            @foreach($kat->menu as $m)
                                <div class="menu-card">
                                    @if($m->gambar)
                                        <img src="{{ asset('uploads/menu/'.$m->gambar) }}" alt="{{ $m->nama_menu }}"
                                            width="220" height="180" loading="lazy" decoding="async">
                                    @else
                                        <div class="no-img">No Image</div>
                                    @endif
                                    <div class="menu-info">
                                        <h3>{{ $m->nama_menu }}</h3>
                                        @if($m->deskripsi)
                                            <div class="deskripsi">{{ $m->deskripsi }}</div>
                                        @endif
                                        <div class="harga">Rp {{ number_format($m->harga, 0, ',', '.') }}</div>
                                       <div class="menu-action">
                                            <button
                                                type="button"
                                                class="btn-tambah"
                                                data-id="{{ $m->id }}"
                                                data-nama="{{ $m->nama_menu }}"
                                                data-harga="{{ $m->harga }}"
                                                data-stok="{{ $m->stok }}"
                                                data-kustom="{{ $m->kategori->perlu_kustomisasi ? '1' : '0' }}"
                                            >
                                                Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </main>
    </div>

    {{-- TOMBOL KERANJANG MENGAMBANG --}}
    <button type="button" class="fab-cart" id="fab-cart" onclick="bukaModalCart()">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
        <span class="fab-cart-badge" id="fab-cart-badge">0</span>
    </button>

    <div class="modal-overlay" id="modal-kustom">
        <div class="modal-box">
            <h3 id="kustom-judul">Custom Pesanan</h3>

            <div class="opsi-group">
                <label class="judul">Level Gula</label>
                <span class="opsi-pill gula-pill active" data-value="Normal">Normal</span>
                <span class="opsi-pill gula-pill" data-value="Kurang Manis">Kurang Manis</span>
                <span class="opsi-pill gula-pill" data-value="Tanpa Gula">Tanpa Gula</span>
            </div>

            <div class="opsi-group">
                <label class="judul">Level Es</label>
                <span class="opsi-pill es-pill active" data-value="Normal">Normal</span>
                <span class="opsi-pill es-pill" data-value="Sedikit Es">Sedikit Es</span>
                <span class="opsi-pill es-pill" data-value="Tanpa Es">Tanpa Es</span>
            </div>

            <button type="button" class="btn-full" id="btn-kustom-tambah">Tambahkan ke Keranjang</button>
            <button type="button" class="btn-outline" onclick="tutupModalKustom()">Batal</button>
        </div>
    </div>

    <div class="modal-overlay" id="modal-cart">
        <div class="modal-box">
            <h3>Keranjang Kamu</h3>
            <div id="cart-items"></div>

            <div class="cart-total-row">
                <span>Total</span>
                <span id="cart-modal-total">Rp 0</span>
            </div>

            <button type="button" class="btn-full" id="btn-checkout">Checkout</button>
            <button type="button" class="btn-outline" onclick="tutupModalCart()">Tambah Menu Lagi</button>
        </div>
    </div>

    {{-- MODAL ALERT --}}
    <div class="modal-overlay" id="modal-alert">
        <div class="modal-box alert-box">
                        <div class="alert-icon-wrap"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 1 21h22L12 2zm0 15h-1v-2h1v2zm0-4h-1V9h1v4z"/></svg></div>
            <h3 id="alert-judul">Perhatian</h3>
            <p id="alert-pesan"></p>
            <button type="button" class="btn-full" onclick="tutupModalAlert()">Mengerti</button>
        </div>
    </div>

    <script>
        const MAX_QTY_PER_MENU = 100;

        let keranjang = @json($cartItems ?? []);
        let itemDipilih = null;

        /* ===== TOGGLE NAVBAR MOBILE ===== */
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

        /* ===== MODAL ALERT (pengganti alert() bawaan browser) ===== */
        function tampilkanAlert(pesan, judul) {
            document.getElementById('alert-judul').textContent = judul || 'Perhatian';
            document.getElementById('alert-pesan').textContent = pesan;
            document.getElementById('modal-alert').classList.add('show');
        }
        function tutupModalAlert() {
            document.getElementById('modal-alert').classList.remove('show');
        }
        document.getElementById('modal-alert').addEventListener('click', function (e) {
            if (e.target === this) tutupModalAlert();
        });

        const PESAN_BATAS_STOK = 'Maaf, jumlah pesanan untuk menu ini sudah mencapai batas yang tersedia.';

        function batasUntukMenu(stok) {
            stok = parseInt(stok);
            if (isNaN(stok)) stok = MAX_QTY_PER_MENU;
            return Math.min(MAX_QTY_PER_MENU, stok);
        }

        function totalQtyUntukMenu(menuId) {
            return keranjang.filter(i => String(i.id) === String(menuId)).reduce((s, i) => s + i.qty, 0);
        }

        function clampInputLive(inputEl) {
            const digits = inputEl.value.replace(/[^0-9]/g, '');

            if (digits === '') {
                inputEl.value = '';
                return;
            }

            let num = parseInt(digits, 10);
            const batas = batasUntukMenu(inputEl.dataset.stok);

            if (num > batas) {
                num = batas;
                if (inputEl.dataset.sudahAlert !== '1') {
                    tampilkanAlert(PESAN_BATAS_STOK);
                    inputEl.dataset.sudahAlert = '1';
                }
            } else {
                inputEl.dataset.sudahAlert = '';
            }

            inputEl.value = String(num);
        }

        /* ===== SEARCH MENU ===== */
        function toggleSearchBar() {
            const wrap = document.getElementById('search-bar-wrap');
            const btn = document.getElementById('search-toggle-btn');
            wrap.classList.toggle('show');
            btn.classList.toggle('active');

            if (wrap.classList.contains('show')) {
                document.getElementById('search-input').focus();
            } else {
                document.getElementById('search-input').value = '';
                filterMenuBySearch('');
            }
        }

        function filterMenuBySearch(keyword) {
            keyword = keyword.trim().toLowerCase();

            document.querySelectorAll('.menu-card').forEach(card => {
                const nama = card.querySelector('h3')?.textContent.toLowerCase() || '';
                card.style.display = nama.includes(keyword) ? '' : 'none';
            });

            // Saat search aktif, matiin filter kategori chip biar hasil search
            // gak ketutup section yang lagi disembunyiin
            const semuaSection = document.querySelectorAll('.kategori-section, .rekomendasi-section');
            if (keyword !== '') {
                semuaSection.forEach(sec => sec.style.display = '');
                document.querySelectorAll('.kategori-chip').forEach(c => c.classList.remove('active'));
            } else {
                document.querySelector('.kategori-chip[data-kategori="all"]').classList.add('active');
                semuaSection.forEach(sec => sec.style.display = '');
            }
        }

        document.querySelectorAll('.kategori-chip').forEach(chip => {
                chip.addEventListener('click', function () {
                    document.querySelectorAll('.kategori-chip').forEach(c => {
                        c.classList.remove('active');
                    });

                    this.classList.add('active');

                    const kat = this.dataset.kategori;

                    document.querySelectorAll('.kategori-section').forEach(sec => {
                        if (kat === 'all') {
                            sec.style.display = '';
                        } else {
                            sec.style.display =
                                sec.dataset.kategoriSection === kat
                                ? ''
                                : 'none';
                        }
                    });

                    const rekomendasi = document.querySelector('.rekomendasi-section');

                    if (rekomendasi) {
                        if (kat === 'all') {
                            rekomendasi.style.display = '';
                        } else {
                            rekomendasi.style.display = 'none';
                        }
                    }
                });
            });

        function findSimpleCartIndex(menuId) {
            return keranjang.findIndex(i => String(i.id) === String(menuId) && !i.gula && !i.es);
        }

        function getSimpleQty(menuId) {
            const idx = findSimpleCartIndex(menuId);
            return idx >= 0 ? keranjang[idx].qty : 0;
        }

        function updateCardQtyDisplay(menuId) {
            // Sengaja dikosongkan — tombol "Tambah" di kartu menu sekarang selalu
            // tampil, konsisten untuk semua jenis menu (kustom maupun simpel).
        }

        function setSimpleQty(menuId, nama, harga, qty, stok) {
            const batas = batasUntukMenu(stok);
            qty = parseInt(qty);
            if (isNaN(qty) || qty < 0) qty = 0;

            let terpotong = false;
            if (qty > batas) {
                qty = batas;
                terpotong = true;
            }

            const idx = findSimpleCartIndex(menuId);

            if (qty === 0) {
                if (idx >= 0) keranjang.splice(idx, 1);
            } else if (idx >= 0) {
                keranjang[idx].qty = qty;
                keranjang[idx].stok = stok;
            } else {
                keranjang.push({ id: menuId, nama, harga, qty, gula: null, es: null, stok });
            }

            updateCardQtyDisplay(menuId);
            renderCartBar();
            syncCartToServer();

            if (terpotong) {
                tampilkanAlert(PESAN_BATAS_STOK);
            }
        }

        function refreshAllCardQty() {
            document.querySelectorAll('.qty-menu-control').forEach(ctrl => {
                updateCardQtyDisplay(ctrl.dataset.menuId);
            });
        }

        document.querySelectorAll('.btn-tambah').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                const harga = parseInt(this.dataset.harga);
                const stok = this.dataset.stok;
                const butuhKustom = this.dataset.kustom === '1';

                if (!butuhKustom) {
                    const currentQty = getSimpleQty(id);
                    setSimpleQty(id, nama, harga, currentQty + 1, stok);
                    return;
                }

                itemDipilih = { id, nama, harga, stok };
                document.getElementById('kustom-judul').textContent = 'Custom - ' + nama;
                document.querySelectorAll('.gula-pill').forEach(p => p.classList.remove('active'));
                document.querySelector('.gula-pill[data-value="Normal"]').classList.add('active');
                document.querySelectorAll('.es-pill').forEach(p => p.classList.remove('active'));
                document.querySelector('.es-pill[data-value="Normal"]').classList.add('active');

                document.getElementById('modal-kustom').classList.add('show');
            });
        });

        document.addEventListener('click', function (e) {
            const isPlus = e.target.classList.contains('btn-menu-plus');
            const isMinus = e.target.classList.contains('btn-menu-minus');
            if (!isPlus && !isMinus) return;

            const ctrl = e.target.closest('.qty-menu-control');
            if (!ctrl) return;

            const menuId = ctrl.dataset.menuId;
            const input = ctrl.querySelector('.qty-number-input');
            let qty = parseInt(input.value) || 0;

            qty = isPlus ? qty + 1 : qty - 1;

            const btnTambah = document.querySelector('.btn-tambah[data-id="' + menuId + '"]');
            const nama = btnTambah ? btnTambah.dataset.nama : '';
            const harga = btnTambah ? parseInt(btnTambah.dataset.harga) : 0;
            const stok = btnTambah ? btnTambah.dataset.stok : MAX_QTY_PER_MENU;

            setSimpleQty(menuId, nama, harga, qty, stok);
        });

        document.addEventListener('change', function (e) {
            if (!e.target.classList.contains('qty-number-input')) return;

            const ctrl = e.target.closest('.qty-menu-control');
            if (!ctrl) return;

            const menuId = ctrl.dataset.menuId;

            const btnTambah = document.querySelector('.btn-tambah[data-id="' + menuId + '"]');
            const nama = btnTambah ? btnTambah.dataset.nama : '';
            const harga = btnTambah ? parseInt(btnTambah.dataset.harga) : 0;
            const stok = btnTambah ? btnTambah.dataset.stok : MAX_QTY_PER_MENU;

            setSimpleQty(menuId, nama, harga, e.target.value, stok);
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('qty-number-input')) {
                e.target.select();
            }
        });

        document.querySelectorAll('.gula-pill').forEach(p => {
            p.addEventListener('click', function () {
                document.querySelectorAll('.gula-pill').forEach(x => x.classList.remove('active'));
                this.classList.add('active');
            });
        });
        document.querySelectorAll('.es-pill').forEach(p => {
            p.addEventListener('click', function () {
                document.querySelectorAll('.es-pill').forEach(x => x.classList.remove('active'));
                this.classList.add('active');
            });
        });

        function tutupModalKustom() {
            document.getElementById('modal-kustom').classList.remove('show');
        }

        document.getElementById('btn-kustom-tambah').addEventListener('click', function () {
            const gula = document.querySelector('.gula-pill.active').dataset.value;
            const es = document.querySelector('.es-pill.active').dataset.value;

            tambahKeKeranjang(itemDipilih.id, itemDipilih.nama, itemDipilih.harga, gula, es, itemDipilih.stok);
            tutupModalKustom();
        });

        function tambahKeKeranjang(id, nama, harga, gula, es, stok) {
            const batas = batasUntukMenu(stok);

            if (totalQtyUntukMenu(id) >= batas) {
                tampilkanAlert(PESAN_BATAS_STOK);
                return;
            }

            const existing = keranjang.find(i => String(i.id) === String(id) && i.gula === gula && i.es === es);

            if (existing) {
                existing.qty++;
            } else {
                keranjang.push({ id, nama, harga, qty: 1, gula, es, stok });
            }

            renderCartBar();
            syncCartToServer();
        }

        function getTotal() {
            return keranjang.reduce((sum, i) => sum + i.harga * i.qty, 0);
        }

        function renderCartBar() {
            const totalItem = keranjang.reduce((s, i) => s + i.qty, 0);
            const badge = document.getElementById('fab-cart-badge');

            if (badge) {
                if (totalItem > 0) {
                    badge.textContent = totalItem;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }
        }

        function bukaModalCart() {
            renderCartModal();
            document.getElementById('modal-cart').classList.add('show');
        }

        function tutupModalCart() {
            document.getElementById('modal-cart').classList.remove('show');
        }

        function renderCartModal() {
            const container = document.getElementById('cart-items');
            container.innerHTML = '';

            if (keranjang.length === 0) {
                container.innerHTML = '<p style="text-align:center; color:#999; font-size:13px; padding:20px 0;">Keranjang kamu masih kosong.</p>';
            }

            keranjang.forEach((item, index) => {
                const ket = item.gula ? `${item.gula}, ${item.es}` : '';
                const batas = batasUntukMenu(item.stok);
                container.innerHTML += `
                    <div class="cart-item">
                        <div>
                            <div class="nama">${item.nama}</div>
                            ${ket ? `<div class="ket">${ket}</div>` : ''}
                        </div>
                        <div class="qty-control">
                            <button type="button" onclick="ubahQty(${index}, -1)">-</button>
                            <input type="number" value="${item.qty}" min="0" max="${batas}" data-stok="${item.stok ?? ''}"
                                oninput="clampInputLive(this)" onchange="setQtyByIndex(${index}, this.value)" onclick="this.select()">
                            <button type="button" onclick="ubahQty(${index}, 1)">+</button>
                        </div>
                    </div>
                `;
            });

            document.getElementById('cart-modal-total').textContent = 'Rp ' + getTotal().toLocaleString('id-ID');
        }

        function ubahQty(index, delta) {
            if (!keranjang[index]) return;

            const item = keranjang[index];
            const batas = batasUntukMenu(item.stok);

            let qty = item.qty + delta;
            let terpotong = false;

            if (qty > batas) {
                qty = batas;
                terpotong = true;
            }
            if (qty < 0) qty = 0;

            item.qty = qty;
            if (qty === 0) keranjang.splice(index, 1);

            renderCartModal();
            renderCartBar();
            refreshAllCardQty();
            syncCartToServer();

            if (terpotong) {
                tampilkanAlert(PESAN_BATAS_STOK);
            }
        }

        function setQtyByIndex(index, rawValue) {
            if (!keranjang[index]) return;

            const item = keranjang[index];
            const batas = batasUntukMenu(item.stok);

            let qty = parseInt(rawValue);
            if (isNaN(qty) || qty < 0) qty = 0;

            let terpotong = false;
            if (qty > batas) {
                qty = batas;
                terpotong = true;
            }

            item.qty = qty;
            if (qty === 0) keranjang.splice(index, 1);

            renderCartModal();
            renderCartBar();
            refreshAllCardQty();
            syncCartToServer();

            if (terpotong) {
                tampilkanAlert(PESAN_BATAS_STOK);
            }
        }

        let syncTimeout = null;
        function syncCartToServer() {
            clearTimeout(syncTimeout);
            syncTimeout = setTimeout(() => {
                const items = keranjang.map(item => ({
                    menu_id: item.id,
                    qty: item.qty,
                    gula: item.gula,
                    es: item.es
                }));

                fetch("{{ route('order.cart.sync', $meja->kode_qr) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ items: items })
                }).catch(() => {});
            }, 300);
        }

        document.getElementById('btn-checkout').addEventListener('click', function () {
            if (keranjang.length === 0) return;

            const items = keranjang.map(item => ({
                menu_id: item.id,
                qty: item.qty,
                gula: item.gula,
                es: item.es
            }));

            fetch("{{ route('order.cart.sync', $meja->kode_qr) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ items: items })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = "{{ route('order.checkout.page', $meja->kode_qr) }}";
                } else {
                    tampilkanAlert('Gagal menyimpan keranjang, coba lagi.');
                }
            })
            .catch(() => {
                tampilkanAlert('Terjadi kesalahan, coba lagi.');
            });
        });

         /* ===== DRAG-TO-CLOSE UNTUK SEMUA MODAL BOTTOM SHEET ===== */
        document.querySelectorAll('.modal-box').forEach(function (box) {
            const handle = document.createElement('div');
            handle.className = 'modal-drag-handle';
            handle.innerHTML = '<span class="modal-drag-bar"></span>';
            box.prepend(handle);

            const overlay = box.closest('.modal-overlay');
            let startY = 0;
            let currentY = 0;
            let dragging = false;

            function mulaiDrag(e) {
                dragging = true;
                startY = e.touches ? e.touches[0].clientY : e.clientY;
                box.style.transition = 'none';
            }

            function saatDrag(e) {
                if (!dragging) return;
                currentY = e.touches ? e.touches[0].clientY : e.clientY;
                const delta = currentY - startY;
                if (delta > 0) {
                    box.style.transform = 'translateY(' + delta + 'px)';
                }
            }

            function akhirDrag() {
                if (!dragging) return;
                dragging = false;

                const delta = currentY - startY;
                box.style.transition = 'transform 0.25s ease';

                if (delta > 120) {
                    overlay.classList.remove('show');
                }

                box.style.transform = '';
                startY = 0;
                currentY = 0;
            }

            handle.addEventListener('touchstart', mulaiDrag, { passive: true });
            handle.addEventListener('touchmove', saatDrag, { passive: true });
            handle.addEventListener('touchend', akhirDrag);

            handle.addEventListener('mousedown', mulaiDrag);
            document.addEventListener('mousemove', saatDrag);
            document.addEventListener('mouseup', akhirDrag);
        });

        renderCartBar();
        refreshAllCardQty();
    </script>

</body>
</html>