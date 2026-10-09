<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raund Raund</title>
     <link rel="icon" type="image/png" href="{{ asset('images/logo.webp') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://images.unsplash.com">

        <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"></noscript>

        <link rel="preload" as="image" fetchpriority="high" href="{{ asset('images/hero.webp') }}">


    <style>
    :root {
        --dark: #291C0E;
        --brown: #6E473B;
        --tan: #A78D78;
        --grey-beige: #BEB5A9;
        --cream: #E1D4C2;
        --bg: #FAF9F7;
        --bg-soft: #F3ECE1;
        --bg-soft-light: #f7f2ea;
        --shadow-sm: 0 4px 14px rgba(41,28,14,0.06);
        --shadow-md: 0 12px 32px rgba(41,28,14,0.12);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--dark);
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; }
        img { display: block; }

        .icon-svg {
            width: 1em;
            height: 1em;
            display: inline-block;
            vertical-align: -0.125em;
            fill: currentColor;
            flex-shrink: 0;
        }

        /* SCROLL REVEAL */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.in-view {
            opacity: 1;
            transform: translateY(0);
        }

        /* NAVBAR */
        .navbar {
            background: rgba(250, 249, 247, 0.92);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: var(--dark);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 32px;
            position: sticky;
            top: 0;
            z-index: 30;
            border-bottom: 1px solid rgba(41,28,14,0.06);
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-brand .brand-text {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark);
        }
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 22px;
        }
        .navbar nav {
            display: flex;
            gap: 28px;
        }
        .navbar nav a {
            color: #6b5d4f;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.2px;
            transition: color 0.2s ease;
            position: relative;
        }
        .navbar nav a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--brown);
            transition: width 0.25s ease;
        }
        .navbar nav a:hover,
        .navbar nav a.active {
            color: var(--dark);
        }

        .navbar nav a:hover::after,
        .navbar nav a.active::after {
            width: 100%;
        }

        section {
            scroll-margin-top: 90px;
        }

        #kontak {
            scroll-margin-top: 90px;
        }
        .navbar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: var(--dark);
            cursor: pointer;
        }
        .mobile-menu {
            display: none;
            flex-direction: column;
            background: #fff;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            padding: 8px 24px 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            border-bottom: 1px solid rgba(41,28,14,0.06);
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu a {
            padding: 12px 0;
            color: #6b5d4f;
            font-size: 14px;
            font-weight: 500;
            border-bottom: 1px solid rgba(41,28,14,0.05);
        }
        .mobile-menu a:last-child { border-bottom: none; }

        /* KEPADATAN BADGE */
        .kepadatan-badge {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 12px 26px;
            border-radius: 18px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.18);
            margin-bottom: 22px;
        }
        .kepadatan-line1 {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .kepadatan-line2 {
            font-size: 11px;
            font-weight: 500;
            color: var(--grey-beige);
            letter-spacing: 0.3px;
        }
        .kepadatan-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .kepadatan-dot.green { background: #4CAF50; }
        .kepadatan-dot.yellow { background: #FFC107; }
        .kepadatan-dot.red { background: #E53935; }

        /* HERO */
        .hero {
            background: linear-gradient(rgba(41,28,14,0.6), rgba(41,28,14,0.6)),
                url('{{ asset("images/hero.webp") }}');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 110px 24px 100px;
            text-align: center;
        }
        .hero h1 {
            font-size: 38px;
            font-weight: 700;
            line-height: 1.25;
            margin-bottom: 16px;
            max-width: 560px;
            margin-left: auto;
            margin-right: auto;
        }
        .hero p {
            font-size: 14.5px;
            color: var(--cream);
            max-width: 460px;
            margin: 0 auto 28px;
            line-height: 1.7;
        }
        .btn-hero {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            color: var(--dark);
            padding: 14px 30px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 13.5px;
            letter-spacing: 0.3px;
            transition: transform 0.2s ease, background 0.2s ease;
        }
        .btn-hero:hover { background: var(--cream); transform: translateY(-2px); }

        section { padding: 76px 24px; width: 100%; }
        .section-inner { max-width: 1080px; margin: 0 auto; }

        .eyebrow {
            display: block;
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--tan);
            margin-bottom: 10px;
        }
        .section-title {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
            color: var(--dark);
        }
        .section-sub {
            text-align: center;
            color: #9a8c7c;
            font-size: 13px;
            margin-bottom: 40px;
        }

        /* TENTANG */
        #tentang { background: var(--bg); }
        .tentang { display: flex; gap: 56px; align-items: center; flex-wrap: wrap; }
        .tentang img {
            flex: 1;
            min-width: 300px;
            border-radius: 20px;
            height: 340px;
            object-fit: cover;
            box-shadow: var(--shadow-md);
        }
        .tentang .teks { flex: 1; min-width: 280px; }
        .tentang .teks .eyebrow { text-align: left; margin-bottom: 12px; }
        .tentang .teks h2 {
            font-size: 24px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 16px;
        }
        .tentang .teks p {
            font-size: 13.5px;
            line-height: 1.85;
            color: #6b5d4f;
            margin-bottom: 28px;
        }
        .fitur-list { display: flex; gap: 32px; flex-wrap: wrap; }
        .fitur-item { display: flex; align-items: center; gap: 12px; }
        .fitur-item .ikon {
            width: 40px; height: 40px; border-radius: 12px;
            background: var(--cream); color: var(--brown);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; flex-shrink: 0;
        }
        .fitur-item .label { font-size: 13px; font-weight: 600; color: var(--dark); }
        .fitur-item .sub { font-size: 11.5px; color: #9a8c7c; margin-top: 2px; }

        /* VOUCHER */
        #voucher { background: var(--bg-soft); }
        .voucher-slider {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            cursor: grab;
            user-select: none;
        }
        .voucher-slider:active { cursor: grabbing; }
        .voucher-slider-track {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.4,0,0.2,1);
        }
        .voucher-banner-card {
            flex: 0 0 100%;
            background: linear-gradient(135deg, var(--dark) 0%, var(--brown) 100%);
            color: #fff;
            padding: 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 32px;
            min-height: 240px;
        }
        .voucher-banner-left { flex: 1; min-width: 0; }
        .voucher-banner-badge {
            display: inline-flex; align-items: center; gap: 8px;
            border: 1px solid rgba(255,255,255,0.3);
            color: #E0A527; font-size: 11px; font-weight: 700;
            letter-spacing: 1px; text-transform: uppercase;
            padding: 7px 16px; border-radius: 100px; margin-bottom: 18px;
        }
        .voucher-banner-title { font-size: 24px; font-weight: 700; line-height: 1.3; margin-bottom: 14px; }
        .voucher-banner-desc { font-size: 13px; color: var(--grey-beige); line-height: 1.7; max-width: 420px; }
        .voucher-banner-right { text-align: center; flex-shrink: 0; }
        .voucher-banner-value { font-size: 40px; font-weight: 800; line-height: 1; }
        .voucher-banner-sub { font-size: 11.5px; font-weight: 700; letter-spacing: 2px; color: var(--tan); margin: 6px 0 18px; }
        .voucher-banner-btn {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff; padding: 12px 26px; border-radius: 100px;
            font-weight: 700; font-size: 12.5px; cursor: pointer;
            transition: background 0.2s ease; white-space: nowrap;
        }
        .voucher-banner-btn:hover { background: rgba(255,255,255,0.25); }
        .voucher-banner-btn.copied { background: #4CAF50; border-color: #4CAF50; }
        .voucher-dots { display: flex; justify-content: center; gap: 8px; margin-top: 20px; }
        .voucher-dot { width: 8px; height: 8px; border-radius: 50%; background: #ddd; cursor: pointer; transition: all 0.2s ease; }
        .voucher-dot.active { background: var(--brown); width: 22px; border-radius: 10px; }

        /* MENU */
        #menu { background: var(--bg); }
        .menu-header-row {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 32px; flex-wrap: wrap; gap: 12px;
        }
        .menu-header-row .titles { text-align: left; }
        .menu-header-row .eyebrow { text-align: left; }
        .menu-header-row .section-title { text-align: left; margin-bottom: 4px; }
        .lihat-semua {
            font-size: 12.5px; font-weight: 600; color: var(--brown);
            white-space: nowrap; background: none; border: none; cursor: pointer; font-family: inherit;
        }
        .lihat-semua:hover { text-decoration: underline; }
        .menu-preview-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .menu-preview-card { background: #fff; border-radius: 18px; overflow: hidden; box-shadow: var(--shadow-sm); }
        .menu-preview-card .thumb-wrap { position: relative; }
        .menu-preview-card img { width: 100%; height: 150px; object-fit: cover; }
        .menu-preview-card .no-img {
            width: 100%; height: 150px; background: var(--cream);
            display: flex; align-items: center; justify-content: center; font-size: 26px;
        }
        .signature-badge {
            position: absolute; top: 10px; left: 10px;
            background: var(--dark); color: #fff; font-size: 9.5px; font-weight: 700;
            letter-spacing: 0.5px; text-transform: uppercase; padding: 5px 10px; border-radius: 100px;
        }
        .rating-badge-landing {
            position: absolute; top: 10px; right: 10px; background: #fff;
            padding: 4px 9px; border-radius: 100px; font-size: 11px; font-weight: 700;
            color: var(--dark); box-shadow: var(--shadow-sm);
        }

        .rating-badge-landing .icon-svg { color: #E0A527; margin-right: 2px; }

        .menu-preview-card .info { padding: 16px; }

        .menu-preview-card h4 { font-size: 14px; font-weight: 600; margin-bottom: 4px; }

        .menu-preview-card .deskripsi-mini {
            font-size: 11.5px; color: #9a8c7c; line-height: 1.5; margin-bottom: 10px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .menu-preview-card .harga { color: var(--brown); font-weight: 700; font-size: 13.5px; }

        .menu-note { text-align: center; font-size: 12.5px; color: #9a8c7c; margin-top: 24px; }

        /* GALERI */
        /* GALERI */
        #galeri { background: var(--bg-soft-light); }
        .galeri-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-auto-rows: 172px;
            gap: 16px;
        }
        .galeri-grid img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            transition: transform 0.3s ease;
        }
        .galeri-grid img:first-child {
            grid-row: span 2;
        }
        .galeri-grid img:hover {
            transform: scale(1.03);
        }

        /* MODAL SEMUA MENU */
        .modal-overlay {
            display: none; position: fixed; inset: 0; background: rgba(20,14,8,0.65);
            z-index: 100; align-items: center; justify-content: center; padding: 20px;
        }
        .modal-overlay.open { display: flex; }
        .modal-box-menu {
            background: #fff; border-radius: 20px; padding: 28px; max-width: 900px;
            width: 100%; max-height: 85vh; display: flex; flex-direction: column;
        }
        .modal-menu-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
        .modal-menu-header h3 { font-size: 19px; font-weight: 700; }
        .modal-close { background: none; border: none; font-size: 24px; line-height: 1; cursor: pointer; color: #9a8c7c; }
        .menu-kategori-tabs { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; }
        .kategori-tab {
            padding: 8px 18px; border-radius: 100px; border: 1.5px solid #eee; background: #fff;
            color: #6b5d4f; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;
        }
        .kategori-tab:hover { border-color: var(--tan); }
        .kategori-tab.active { background: var(--dark); border-color: var(--dark); color: #fff; }
        .modal-menu-body { overflow-y: auto; padding-right: 4px; }
        .menu-grid-landing { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }

        /* ULASAN */
        #ulasan { background: var(--bg-soft); }
        .ulasan-avg-badge {
            display: inline-flex; align-items: center; gap: 4px; background: #fff;
            color: var(--brown); padding: 4px 12px; border-radius: 20px;
            font-weight: 700; font-size: 12.5px; margin-right: 6px; box-shadow: var(--shadow-sm);
        }
        .ulasan-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; }
        .ulasan-card { background: #fff; border-radius: 18px; padding: 26px; box-shadow: var(--shadow-sm); }
        .ulasan-stars { margin-bottom: 14px; }
        .ulasan-stars .star { font-size: 15px; }
        .ulasan-komentar {
            font-size: 13.5px; line-height: 1.75; color: #5c5044; margin-bottom: 20px; font-style: italic;
        }
        .ulasan-user { display: flex; align-items: center; gap: 12px; }
        .ulasan-avatar {
            width: 40px; height: 40px; border-radius: 50%; background: var(--brown); color: #fff;
            display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12.5px; flex-shrink: 0;
        }
        .ulasan-nama { font-size: 13.5px; font-weight: 700; color: var(--dark); }
        .ulasan-sub { font-size: 11.5px; color: #9a8c7c; }

        /* KONTAK (dipisah dari footer) */
        #kontak {
            background: linear-gradient(180deg, var(--dark) 0%, var(--brown) 100%);
            color: var(--grey-beige);
            max-width: 100%;
        }
        #kontak .inner { max-width: 1080px; margin: 0 auto; padding: 76px 24px; }
        #kontak .section-title { color: #fff; }
        #kontak .section-sub { color: var(--tan); }
        .kontak-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 20px; }
        .kontak-card h3 {
            font-size: 17px; font-weight: 700; color: #fff;
            display: flex; align-items: center; gap: 10px; margin-bottom: 16px;
        }
        .kontak-card h3 .ic {
            width: 34px; height: 34px; border-radius: 50%;
            background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center;
            font-size: 13px; flex-shrink: 0;
        }
        .kontak-card p { font-size: 13px; color: var(--grey-beige); line-height: 1.8; margin-bottom: 6px; }
        .kontak-map {
            width: 100%; height: 180px; border: none; border-radius: 14px; margin-top: 14px;
            filter: grayscale(0.3) contrast(1.05);
        }
        .kontak-links { display: flex; flex-direction: column; gap: 12px; margin-top: 6px; }
        .kontak-links a {
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            color: #fff; padding: 14px 18px; border-radius: 14px; font-size: 13px; font-weight: 600;
            transition: background 0.2s ease;
        }
        .kontak-links a:hover { background: rgba(255,255,255,0.12); }
        .kontak-links a .left { display: flex; align-items: center; gap: 12px; }
        .kontak-links a .sub { font-size: 11px; font-weight: 400; color: var(--grey-beige); margin-top: 2px; }
        .kontak-links a .ikon {
            width: 34px; height: 34px; border-radius: 50%; background: rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center; font-size: 14px;
        }

        /* FOOTER (dark solid, senada dengan warna atas Kontak, tanpa duplikasi info) */
        footer {
            background: var(--dark);
            color: var(--grey-beige);
            padding: 32px 24px 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .footer-inner {
            max-width: 1080px;
            margin: 0 auto;
        }

       .footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 0.8fr 1fr;
            gap: 50px;
            align-items: start;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 16px;
            text-align: left;
        }

        .footer-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
        .footer-brand img { height: 34px; }
        .footer-brand span { font-size: 16px; font-weight: 600; color: #fff; }
        .footer-tagline {
            font-size: 12.5px; color: var(--grey-beige); line-height: 1.8;
            max-width: 320px; margin-bottom: 18px;
        }
        .footer-social a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--grey-beige);
            font-size: 12.5px;
            transition: color 0.2s ease;
        }
        
        .footer-social a:hover {
            color: #fff;
        }

        .footer-social a .icon-svg {
            font-size: 15px;
            width: 18px;
        }

        .footer-col h4 {
            color: #fff; font-size: 12.5px; font-weight: 700;
            letter-spacing: 0.8px; text-transform: uppercase; margin-bottom: 18px;
        }
        .footer-col p {
            font-size: 12.5px; color: var(--grey-beige); line-height: 1.9; margin-bottom: 4px;
            display: flex; align-items: flex-start; gap: 8px;
        }
        .footer-col p i { width: 14px; margin-top: 2px; color: var(--tan); }
        .footer-col a {
            display: block; font-size: 12.5px; color: var(--grey-beige);
            line-height: 2.3; transition: color 0.2s ease;
        }
        .footer-col a:hover { color: #fff; }

        .footer-bottom-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            font-size: 11.5px;
            color: #9a8c7c;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .navbar nav { display: none; }
            .navbar-toggle { display: block; }
            .hero { padding: 80px 20px 70px; }
            .hero h1 { font-size: 28px; }
            .hero p { font-size: 13.5px; }
            section { padding: 56px 20px; }
            #kontak .inner { padding: 56px 20px; }
            .menu-preview-grid { grid-template-columns: repeat(2, 1fr); }
            .galeri-grid { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 160px; }
            .voucher-banner-card { flex-direction: column; text-align: center; padding: 32px 24px; min-height: unset; }
            .voucher-banner-desc { max-width: 100%; }
            .kontak-grid { grid-template-columns: 1fr; gap: 32px; }
            .footer-grid { grid-template-columns: 1fr; gap: 30px; text-align: center; }
            .footer-brand { justify-content: center; }

           .footer-social {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            
            .footer-tagline { max-width: 100%; margin-left: auto; margin-right: auto; }
            .footer-col p { justify-content: center; }
            .footer-bottom-row { justify-content: center; text-align: center; }
        }
        @media (max-width: 480px) {
            .hero h1 { font-size: 24px; }
            .menu-preview-grid { grid-template-columns: 1fr; }
            .voucher-banner-value { font-size: 32px; }
            .modal-box-menu { padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="#beranda" class="navbar-brand">
            <img src="{{ asset('images/logo.webp') }}" alt="Raund Raund" style="height:44px; width:auto;"
                width="44" height="44" fetchpriority="high">
            <span class="brand-text">Raund Raund</span>
        </a>
        <div class="navbar-right">
            <nav>
                <a href="#tentang">Tentang</a>
                <a href="#menu">Menu</a>
                <a href="#galeri">Galeri</a>
                <a href="#ulasan">Ulasan</a>
                <a href="#kontak">Kontak</a>
                <a href="{{ route('login') }}" class="btn-login">Staff Area</a>
            </nav>
            <button type="button" class="navbar-toggle" onclick="toggleMobileMenu()" aria-label="Buka menu navigasi">
                <svg class="icon-svg" viewBox="0 0 24 24"><path d="M3 6h18v2H3zm0 5h18v2H3zm0 5h18v2H3z"/></svg>
            </button>
        </div>

        <div class="mobile-menu" id="mobileMenu">
            <a href="#tentang">Tentang</a>
            <a href="#menu">Menu</a>
            <a href="#galeri">Galeri</a>
            <a href="#ulasan">Ulasan</a>
            <a href="#kontak">Kontak</a>
            <a href="{{ route('login') }}" class="btn-login">Staff Area</a>
        </div>
    </div>

    <main>

    <div class="hero" id="beranda">
        <div class="kepadatan-badge">
            <div class="kepadatan-line1">
                <span class="kepadatan-dot {{ $kepadatan['warna'] }}"></span>
                {{ $kepadatan['label'] }}
            </div>
            <div class="kepadatan-line2">{{ $mejaTerisi }}/{{ $totalMeja }} Meja Terisi</div>
        </div>
        <h1>Selamat Datang di </h1>
        <h1>Raund Raund</h1>
        <p>Nikmati secangkir kopi terbaik dalam suasana yang hangat. Datang, duduk, dan pesan langsung dari meja kamu.</p>
        <a href="#kontak" class="btn-hero">Kunjungi Kami &rarr;</a>
    </div>

    <section id="tentang" class="reveal">
        <div class="section-inner">
        <div class="tentang">
            <img src="{{ asset('images/tentang.webp') }}"
                alt="Suasana kafe" loading="lazy" decoding="async" width="600" height="340">
            <div class="teks">
                <span class="eyebrow">Pengalaman Baru</span>
                <h2>Pesan Tanpa Antre, Nikmati Setiap Momen.</h2>
                <p>
                    Raund Raund hadir sebagai tempat nongkrong yang nyaman buat kamu yang butuh secangkir kopi
                    berkualitas atau sekadar bersantai. Kami menyajikan kopi pilihan, non-kopi, snack, hingga dessert
                    dengan cita rasa terbaik. Pesan langsung dari meja kamu lewat scan QR Code, tanpa perlu antre.
                </p>
                <div class="fitur-list">
                    <div class="fitur-item">
                    <div class="ikon"><svg class="icon-svg" viewBox="0 0 24 24"><path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm10 0h2v2h-2zm4 0h2v2h-2zm-4 4h2v2h-2zm4 0h2v2h-2zm-2-8h2v2h-2z"/></svg></div>
                        <div class="txt">
                            <div class="label">Scan QR</div>
                            <div class="sub">Pindai kode di meja kamu.</div>
                        </div>
                    </div>
                    <div class="fitur-item">
                        <div class="ikon"><svg class="icon-svg" viewBox="0 0 24 24"><path d="M4 3h13v9a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V3zm13 3h2a3 3 0 0 1 0 6h-2v-2h2a1 1 0 0 0 0-2h-2V6zM4 19h13v2H4v-2z"/></svg></div>
                        <div class="txt">
                            <div class="label">Pesan &amp; Duduk Manis</div>
                            <div class="sub">Kami antarkan ke meja kamu.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <section id="voucher" class="reveal">
        <div class="section-inner">
        <span class="eyebrow">Promo Spesial</span>
        <div class="section-title">Voucher Tersedia</div>

        @if($vouchers->count())
            <div class="voucher-slider" id="voucherSlider">
                <div class="voucher-slider-track" id="voucherTrack">
                    @foreach($vouchers as $v)
                        <div class="voucher-banner-card">
                            <div class="voucher-banner-left">
                                <div class="voucher-banner-badge">
                                    <svg class="icon-svg" viewBox="0 0 24 24"><path d="m3 21 9-9-2-2-9 9 2 2zm11-11 2 2 3-3-2-2-3 3zM12 3l1 2 2 1-2 1-1 2-1-2-2-1 2-1 1-2zm7 5 .8 1.6L21 10l-1.2.4L19 12l-.8-1.6L17 10l1.2-.4L19 8z"/></svg> Kode {{ $v->kode }}
                                </div>
                                <h3 class="voucher-banner-title">{{ $v->nama_voucher }}</h3>
                                <p class="voucher-banner-desc">
                                    @if($v->minimal_belanja > 0)
                                        Min. belanja Rp {{ number_format($v->minimal_belanja,0,',','.') }}.
                                    @endif
                                    Berlaku hingga {{ $v->tanggal_expired->format('d M Y') }}. Gunakan kode voucher ini saat checkout lewat scan QR meja kamu.
                                </p>
                            </div>
                            <div class="voucher-banner-right">
                                <div class="voucher-banner-value">
                                    {{ $v->tipe_diskon === 'persen' ? $v->nilai_diskon.'%' : 'Rp '.number_format($v->nilai_diskon,0,',','.') }}
                                </div>
                                <div class="voucher-banner-sub">DISKON</div>
                                <button type="button" class="voucher-banner-btn" onclick="salinKode('{{ $v->kode }}', this)">
                                    Klaim voucher
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if($vouchers->count() > 1)
                <div class="voucher-dots" id="voucherDots">
                    @foreach($vouchers as $i => $v)
                        <span class="voucher-dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"></span>
                    @endforeach
                </div>
            @endif

            <div class="menu-note">
                Gunakan kode voucher di atas saat checkout lewat scan QR meja kamu.
            </div>
        @else
            <div class="menu-note">Belum ada voucher aktif saat ini. Pantau terus ya!</div>
        @endif
        </div>
    </section>

    <section id="menu" class="reveal">
        <div class="section-inner">
        <div class="menu-header-row">
            <div class="titles">
                <span class="eyebrow">Kurasi Kami</span>
                <div class="section-title">Menu Favorit</div>
            </div>
            <button type="button" class="lihat-semua" onclick="openMenuModal()">Lihat Semua Menu &rarr;</button>
        </div>

        <div class="menu-preview-grid">
            @foreach($menuPreview as $m)
                <div class="menu-preview-card">
                    <div class="thumb-wrap">
                        @if($m->gambar)
                            <img src="{{ asset('uploads/menu/'.$m->gambar) }}" alt="{{ $m->nama_menu }}"
                                loading="lazy" decoding="async" width="300" height="150">
                        @else
                            <div class="no-img"><svg class="icon-svg" viewBox="0 0 24 24"><path d="M4 3h13v9a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V3zm13 3h2a3 3 0 0 1 0 6h-2v-2h2a1 1 0 0 0 0-2h-2V6zM4 19h13v2H4v-2z"/></svg></div>
                        @endif

                        @if($topMenuId === $m->id)
                            <span class="signature-badge">Terlaris</span>
                        @endif

                        @if($m->ratings_count > 0)
                            <span class="rating-badge-landing"><svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> {{ number_format($m->ratings_avg_bintang, 1) }}</span>
                        @endif
                    </div>
                    <div class="info">
                        <h4>{{ $m->nama_menu }}</h4>
                        @if($m->deskripsi)
                            <div class="deskripsi-mini">{{ $m->deskripsi }}</div>
                        @endif
                        <div class="harga">Rp {{ number_format($m->harga, 0, ',', '.') }}</div>
                    </div>
                </div>
            @endforeach
        </div>

                <div class="menu-note">
            Pesan menu favoritmu langsung setelah scan QR Code di meja kamu.
        </div>
        </div>
    </section>

    <section id="galeri" class="reveal">
        <div class="section-inner">
        <span class="eyebrow">Sekilas Suasana</span>
        <div class="section-title">Galeri Kami</div>
        <div class="section-sub">Intip suasana hangat Raund Raund sebelum kamu datang langsung.</div>

        <div class="galeri-grid">
            <img src="{{ asset('images/galeri-1.webp') }}" alt="Suasana interior Raund Raund"
                loading="lazy" decoding="async" width="360" height="270">
            <img src="{{ asset('images/galeri-2.webp') }}" alt="Proses menyeduh kopi di Raund Raund"
                loading="lazy" decoding="async" width="360" height="270">
            <img src="{{ asset('images/galeri-3.webp') }}" alt="Menu favorit Raund Raund"
                loading="lazy" decoding="async" width="360" height="270">
            <img src="{{ asset('images/galeri-4.webp') }}" alt="Area duduk nyaman Raund Raund"
                loading="lazy" decoding="async" width="360" height="270">
            <img src="{{ asset('images/galeri-5.webp') }}" alt="Detail kopi Raund Raund"
                loading="lazy" decoding="async" width="360" height="270">
        </div>
        </div>
    </section>

    <div class="modal-overlay" id="menuModal" onclick="if(event.target === this) closeMenuModal()">

        <div class="modal-box-menu">
            <div class="modal-menu-header">
                <h3>Menu Lengkap</h3>
                <button type="button" class="modal-close" onclick="closeMenuModal()" aria-label="Tutup">&times;</button>
            </div>

            <div class="menu-kategori-tabs">
                <button type="button" class="kategori-tab active" data-kategori="all">Semua</button>
                @foreach($kategori as $kat)
                    @if($kat->menu->count())
                        <button type="button" class="kategori-tab" data-kategori="{{ $kat->id }}">{{ $kat->nama_kategori }}</button>
                    @endif
                @endforeach
            </div>

            <div class="modal-menu-body">
                <div class="menu-grid-landing">
                    @foreach($kategori as $kat)
                        @foreach($kat->menu as $m)
                            <div class="menu-preview-card" data-kategori-item="{{ $kat->id }}">
                                <div class="thumb-wrap">
                                    @if($m->gambar)
                                    <img src="{{ asset('uploads/menu/'.$m->gambar) }}" alt="{{ $m->nama_menu }}"
                                        loading="lazy" decoding="async" width="300" height="150">
                                    @else
                                        <div class="no-img"><svg class="icon-svg" viewBox="0 0 24 24"><path d="M4 3h13v9a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V3zm13 3h2a3 3 0 0 1 0 6h-2v-2h2a1 1 0 0 0 0-2h-2V6zM4 19h13v2H4v-2z"/></svg></div>
                                    @endif

                                    @if($topMenuId === $m->id)
                                        <span class="signature-badge">Terlaris</span>
                                    @endif

                                    @if($m->ratings_count > 0)
                                        <span class="rating-badge-landing"><svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> {{ number_format($m->ratings_avg_bintang, 1) }}</span>
                                    @endif
                                </div>
                                <div class="info">
                                    <h4>{{ $m->nama_menu }}</h4>
                                    @if($m->deskripsi)
                                        <div class="deskripsi-mini">{{ $m->deskripsi }}</div>
                                    @endif
                                    <div class="harga">Rp {{ number_format($m->harga, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <section id="ulasan" class="reveal">
        <div class="section-inner">
        <span class="eyebrow">Kata Mereka</span>
        <div class="section-title">Ulasan Pelanggan</div>

        @if($totalRating > 0)
            <div class="section-sub">
                <span class="ulasan-avg-badge"><svg class="icon-svg" style="color:#E0A527;" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> {{ number_format($avgRating, 1) }}</span>
                dari {{ $totalRating }} ulasan
            </div>
        @endif

        @if($reviewsPreview->count())
            <div class="ulasan-grid">
                @foreach($reviewsPreview as $r)
                    @php
                        $namaCustomer = optional(optional($r->detailPesanan)->pesanan)->nama_customer ?: 'Pelanggan';
                        $inisial = collect(explode(' ', $namaCustomer))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
                    @endphp
                    <div class="ulasan-card">
                        <div class="ulasan-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star" style="color:{{ $i <= $r->bintang ? '#E0A527' : '#ddd' }};">&#9733;</span>
                            @endfor
                        </div>
                        <p class="ulasan-komentar">"{{ $r->komentar }}"</p>
                        <div class="ulasan-user">
                            <div class="ulasan-avatar">{{ $inisial }}</div>
                            <div>
                                <div class="ulasan-nama">{{ $namaCustomer }}</div>
                                <div class="ulasan-sub">Menikmati {{ $r->menu->nama_menu ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="menu-note">
                <a href="{{ route('ulasan.index') }}" class="lihat-semua">Lihat Semua Ulasan &rarr;</a>
            </div>
        @else
            <div class="menu-note">Belum ada ulasan. Jadilah yang pertama memberi rating!</div>
        @endif
        </div>
    </section>

    <div id="kontak" class="reveal">
        <div class="inner">
            <span class="eyebrow">Hubungi Kami</span>
            <div class="section-title">Temukan Kami</div>
            <div class="section-sub">Kami siap menyambut Anda dengan secangkir kopi hangat.</div>

            <div class="kontak-grid">
                <div class="kontak-card">
                        <h3><span class="ic"><svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg></span> Lokasi &amp; Jam Buka</h3>
                    <p>Jalan Sudirman, Pekanbaru</p>
                    <p>Senin - Minggu: 08.00 - 22.00 WIB</p>
                    <div class="kontak-map" id="peta-placeholder" onclick="muatPeta()"
                        style="cursor:pointer; background:rgba(255,255,255,0.06); display:flex; flex-direction:column;
                        align-items:center; justify-content:center; gap:10px; color:#fff; text-align:center;">
                        <svg class="icon-svg" style="width:32px; height:32px;" viewBox="0 0 24 24"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg>
                        <span style="font-size:13px; font-weight:600;">Klik untuk lihat peta</span>
                        <span style="font-size:11px; color:var(--grey-beige);">Jalan Sudirman, Pekanbaru</span>
                    </div>
                </div>

                <div class="kontak-card">
                        <h3><span class="ic"><svg class="icon-svg" viewBox="0 0 24 24"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.9 21 3 13.1 3 3c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.2.2 2.5.6 3.6.1.4 0 .7-.2 1L6.6 10.8z"/></svg></span> Mari Terhubung</h3>
                    <p>Ada pertanyaan atau mau reservasi rombongan? Jangan ragu menghubungi kami.</p>
                    <div class="kontak-links">
                        <a href="https://wa.me/6282288512481" target="_blank">
                            <span class="left">
                                    <span class="ikon"><svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.2-1.4A10 10 0 1 0 12 2zm0 18a8 8 0 0 1-4.1-1.1l-.3-.2-3 .8.8-2.9-.2-.3A8 8 0 1 1 12 20zm4.4-5.8c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.5.1s-.6.8-.7.9-.3.2-.5.1a6.6 6.6 0 0 1-3.3-2.9c-.2-.4.2-.4.6-1.2.1-.1 0-.3 0-.4l-.7-1.7c-.2-.4-.4-.4-.5-.4h-.5c-.2 0-.4.1-.6.3a2.7 2.7 0 0 0-.8 2 4.7 4.7 0 0 0 1 2.5 10.6 10.6 0 0 0 4.4 3.9c1.6.7 1.6.5 1.9.4a1.6 1.6 0 0 0 1-.7 1.3 1.3 0 0 0 .1-.7c-.1-.1-.2-.2-.4-.3z"/></svg></span>
                                <span>
                                    WhatsApp
                                    <div class="sub">Chat dengan tim kami</div>
                                </span>
                            </span>
                            <span>&rarr;</span>
                        </a>
                        <a href="https://instagram.com/ridhosirrr_" target="_blank">
                            <span class="left">
                                <span class="ikon"><svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2c2.7 0 3.1 0 4.1.1a5.7 5.7 0 0 1 4.1 4.1c.1 1 .1 1.4.1 4.1s0 3.1-.1 4.1a5.7 5.7 0 0 1-4.1 4.1c-1 .1-1.4.1-4.1.1s-3.1 0-4.1-.1a5.7 5.7 0 0 1-4.1-4.1c-.1-1-.1-1.4-.1-4.1s0-3.1.1-4.1a5.7 5.7 0 0 1 4.1-4.1c1-.1 1.4-.1 4.1-.1zm0 4a4.3 4.3 0 1 0 0 8.6 4.3 4.3 0 0 0 0-8.6zm0 7a2.7 2.7 0 1 1 0-5.4 2.7 2.7 0 0 1 0 5.4zm5.5-7.2a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/></svg></span>
                                <span>
                                    Instagram
                                    <div class="sub">Ikuti keseharian di @ridhosirrr_</div>
                                </span>
                            </span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </main>

    <footer>
        <div class="footer-inner">
            <div class="footer-grid">

            <!-- KOLOM KIRI -->
            <div class="footer-col">
                <div class="footer-brand">
                <img src="{{ asset('images/logo.webp') }}" alt="Raund Raund" loading="lazy" width="34" height="34">
                    <span>Raund Raund</span>
                </div>

                <p class="footer-tagline">
                    Menghadirkan momen ngopi yang hangat lewat racikan pilihan
                    dan suasana yang nyaman untuk berkumpul.
                </p>
            </div>

            <!-- KOLOM TENGAH -->
            <div class="footer-col">
                <h4>Navigasi</h4>

                <a href="#tentang">Tentang</a>
                <a href="#menu">Menu</a>
                <a href="#galeri">Galeri</a>
                <a href="#ulasan">Ulasan</a>
                <a href="#kontak">Kontak</a>
            </div>

            <!-- KOLOM KANAN -->
            <div class="footer-col">
                <h4>Ikuti Kami</h4>

                <div class="footer-social">

                     <a href="https://instagram.com/ridhosirrr_"
                    target="_blank"
                    aria-label="Instagram">
                        <svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2c2.7 0 3.1 0 4.1.1a5.7 5.7 0 0 1 4.1 4.1c.1 1 .1 1.4.1 4.1s0 3.1-.1 4.1a5.7 5.7 0 0 1-4.1 4.1c-1 .1-1.4.1-4.1.1s-3.1 0-4.1-.1a5.7 5.7 0 0 1-4.1-4.1c-.1-1-.1-1.4-.1-4.1s0-3.1.1-4.1a5.7 5.7 0 0 1 4.1-4.1c1-.1 1.4-.1 4.1-.1zm0 4a4.3 4.3 0 1 0 0 8.6 4.3 4.3 0 0 0 0-8.6zm0 7a2.7 2.7 0 1 1 0-5.4 2.7 2.7 0 0 1 0 5.4zm5.5-7.2a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/></svg>
                        Instagram
                    </a>

                   <!--  <a href="#"
                    aria-label="TikTok">
                        <i class="fab fa-tiktok"></i>
                        TikTok
                    </a> -->

                </div>

            </div>

        </div>

            <div class="footer-bottom-row">
                <span>&copy; {{ date('Y') }} Raund Raund. Semua hak cipta dilindungi.</span>
                <span>Dibuat dengan &hearts; di Pekanbaru</span>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('open');
        }
        document.querySelectorAll('.mobile-menu a').forEach(function (a) {
            a.addEventListener('click', function () {
                document.getElementById('mobileMenu').classList.remove('open');
            });
        });

        function muatPeta() {
            var placeholder = document.getElementById('peta-placeholder');
            var iframe = document.createElement('iframe');

            iframe.className = 'kontak-map';
            iframe.src = 'https://www.google.com/maps?q=Jalan+Sudirman,+Pekanbaru&output=embed';
            iframe.loading = 'lazy';

            placeholder.replaceWith(iframe);
        }

        function openMenuModal() {
            document.getElementById('menuModal').classList.add('open');
        }
        function closeMenuModal() {
            document.getElementById('menuModal').classList.remove('open');
        }

        (function () {
            const slider = document.getElementById('voucherSlider');
            if (!slider) return;

            const track = document.getElementById('voucherTrack');
            const dots = document.querySelectorAll('.voucher-dot');
            const totalSlides = track.children.length;
            let currentIndex = 0;
            let autoplayTimer = null;

            function goToSlide(index) {
                currentIndex = (index + totalSlides) % totalSlides;
                track.style.transform = `translateX(-${currentIndex * 100}%)`;
                dots.forEach((dot, i) => dot.classList.toggle('active', i === currentIndex));
            }

            function startAutoplay() {
                stopAutoplay();
                if (totalSlides > 1) {
                    autoplayTimer = setInterval(() => goToSlide(currentIndex + 1), 5000);
                }
            }
            function stopAutoplay() {
                if (autoplayTimer) clearInterval(autoplayTimer);
            }

            dots.forEach(function (dot) {
                dot.addEventListener('click', function () {
                    goToSlide(parseInt(this.dataset.index));
                    startAutoplay();
                });
            });

            let startX = 0;
            let isDragging = false;

            function dragStart(x) { isDragging = true; startX = x; stopAutoplay(); }
            function dragEnd(x) {
                if (!isDragging) return;
                isDragging = false;
                const diff = x - startX;
                if (diff > 50) goToSlide(currentIndex - 1);
                else if (diff < -50) goToSlide(currentIndex + 1);
                startAutoplay();
            }

            slider.addEventListener('mousedown', (e) => dragStart(e.clientX));
            slider.addEventListener('mouseup', (e) => dragEnd(e.clientX));
            slider.addEventListener('mouseleave', () => { if (isDragging) { isDragging = false; startAutoplay(); } });
            slider.addEventListener('touchstart', (e) => dragStart(e.touches[0].clientX), { passive: true });
            slider.addEventListener('touchend', (e) => dragEnd(e.changedTouches[0].clientX));

            startAutoplay();
        })();

        function salinKode(kode, btn) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(kode).then(function () {
                    tampilkanTersalin(btn);
                }).catch(function () {
                    salinFallback(kode, btn);
                });
            } else {
                salinFallback(kode, btn);
            }
        }

        function salinFallback(kode, btn) {
            const textarea = document.createElement('textarea');

            textarea.value = kode;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';

            document.body.appendChild(textarea);

            textarea.focus();
            textarea.select();

            try {
                document.execCommand('copy');
                tampilkanTersalin(btn);
            } catch (err) {
                alert('Kode voucher: ' + kode);
            }

            document.body.removeChild(textarea);
        }

        function tampilkanTersalin(btn) {
            const teksAsli = btn.textContent;

            btn.textContent = '✓ Tersalin!';
            btn.classList.add('copied');

            setTimeout(function () {
                btn.textContent = teksAsli;
                btn.classList.remove('copied');
            }, 1500);
        }

        document.querySelectorAll('.kategori-tab').forEach(function (tab) {
            tab.addEventListener('click', function () {
                document.querySelectorAll('.kategori-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const kategoriId = this.dataset.kategori;
                document.querySelectorAll('[data-kategori-item]').forEach(function (item) {
                    item.style.display = (kategoriId === 'all' || item.dataset.kategoriItem === kategoriId) ? '' : 'none';
                });
            });
        });

        // Scroll reveal animation
        const revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                } else {
                    entry.target.classList.remove('in-view');
                }
            });
        }, { threshold: 0.15 });

        document.querySelectorAll('.reveal').forEach(function (el) {
            revealObserver.observe(el);
        });

        // NAVBAR ACTIVE SAAT SCROLL
        const navLinks = document.querySelectorAll('.navbar nav a');
        const mobileNavLinks = document.querySelectorAll('.mobile-menu a');

        const navSections = [
            document.getElementById('tentang'),
            document.getElementById('menu'),
            document.getElementById('galeri'),
            document.getElementById('ulasan'),
            document.getElementById('kontak')
        ];

        function setActiveNav(id) {
            navLinks.forEach(function (link) {
                link.classList.toggle(
                    'active',
                    link.getAttribute('href') === '#' + id
                );
            });

            mobileNavLinks.forEach(function (link) {
                link.classList.toggle(
                    'active',
                    link.getAttribute('href') === '#' + id
                );
            });
        }

        function updateActiveNav() {
            const scrollPosition = window.scrollY + 120;

            let activeSection = null;

            navSections.forEach(function (section) {
                if (!section) return;

                const sectionTop = section.offsetTop;
                const sectionBottom = sectionTop + section.offsetHeight;

                if (
                    scrollPosition >= sectionTop &&
                    scrollPosition < sectionBottom
                ) {
                    activeSection = section;
                }
            });

            if (activeSection) {
                setActiveNav(activeSection.id);
            } else if (window.scrollY < navSections[0].offsetTop - 120) {
                navLinks.forEach(link => link.classList.remove('active'));
                mobileNavLinks.forEach(link => link.classList.remove('active'));
            }
        }

        window.addEventListener('scroll', updateActiveNav);
        window.addEventListener('load', updateActiveNav);

        navLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                const targetId = this.getAttribute('href').substring(1);
                setActiveNav(targetId);
            });
        });

        mobileNavLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                const targetId = this.getAttribute('href').substring(1);
                setActiveNav(targetId);
            });
        });
    </script>

</body>
</html>