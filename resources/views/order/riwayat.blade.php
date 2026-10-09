<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat - Meja {{ $meja->nomor_meja }}</title>
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
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--dark);
        }
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

        .navbar-menu a.active,
        .navbar-menu a:hover {
            color: var(--white);
        }

        .navbar-menu a.active::after,
        .navbar-menu a:hover::after {
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
        main { max-width: 500px; margin: 0 auto; padding: 24px; }
        h2 { font-family: 'Poppins', sans-serif;margin-bottom: 20px; }
        .empty {
            text-align: center;
            color: #999;
            padding: 60px 20px;
            font-size: 14px;
        }
        .card {
            background: var(--white);
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 4px 20px rgba(41,28,14,0.04);
        }
        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        .kode { font-weight: 700; font-size: 15px; }
        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            background: #e2e3e5;
            color: #383d41;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0ede9;
            font-size: 13px;
        }
        .cart-item:last-child { border-bottom: none; }
        .cart-item .ket { font-size: 11px; color: #999; }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #ddd;
            font-size: 14px;
        }

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
                margin-right: 0;
                background: var(--dark);
                padding: 8px 0;
                box-shadow: 0 20px 50px rgba(0,0,0,0.25);
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
                font-size: 13px;
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
        }

        .rating-block {
            padding: 16px 0;
            border-top: 1px dashed #eee;
            margin-top: 6px;
        }
        .rating-label {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }
        .rating-stars-input {
            display: flex;
            gap: 6px;
            margin-bottom: 12px;
            cursor: pointer;
            user-select: none;
        }
        .rating-stars-input .star-btn {
            font-size: 26px;
            line-height: 1;
            color: #ffffff;
            text-shadow:
                -1px -1px 0 var(--dark),
                1px -1px 0 var(--dark),
                -1px 1px 0 var(--dark),
                1px 1px 0 var(--dark);
            transition: color 0.15s;
            user-select: none;
        }
        .rating-stars-input .star-btn.active {
            color: #E0A527;
            text-shadow:
                -1px -1px 0 #b8811e,
                1px -1px 0 #b8811e,
                -1px 1px 0 #b8811e,
                1px 1px 0 #b8811e;
        }

        .form-rating textarea {
            width: 100%;
            border: 1.5px solid #eee;
            border-radius: 10px;
            padding: 10px;
            font-family: inherit;
            font-size: 12.5px;
            resize: vertical;
            min-height: 50px;
            margin-bottom: 10px;
        }
        .btn-kirim-rating {
            background: var(--dark);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
        }
        .rating-stars-static {
            display: flex;
            gap: 3px;
            margin-bottom: 4px;
        }
        .rating-stars-static .star {
            font-size: 16px;
            color: #ddd;
        }
        .rating-stars-static .star.filled {
            color: #E0A527;
        }
        .rating-comment {
            font-size: 12px;
            color: #999;
            font-style: italic;
        }
        .alert-success, .alert-error {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 13px;
        }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="navbar-left">
           <img src="{{ asset('images/logo.webp') }}" alt="Raund-Raund" style="height:36px; width:auto;">
            <div class="table-badge">Meja {{ $meja->nomor_meja }}</div>
        </div>

        <ul class="navbar-menu" id="navbar-menu">
            <li>
                <a href="{{ route('order.index', $meja->kode_qr) }}">
                    Menu
                </a>
            </li>

            <li>
                <a href="{{ route('order.voucher.list', $meja->kode_qr) }}">
                    Voucher
                </a>
            </li>

            <li>
                <a href="{{ route('order.pesanan', $meja->kode_qr) }}">
                    Pesanan
                </a>
            </li>

            <li>
                <a href="{{ route('order.riwayat', $meja->kode_qr) }}" class="active">
                    Riwayat
                </a>
            </li>
        </ul>

        <button type="button" class="navbar-toggle" id="navbar-toggle" onclick="toggleNavbarMenu()" aria-label="Buka menu navigasi">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
    </nav>

    <main>
        <h2>Riwayat Pesanan</h2>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if($riwayatSaya->isEmpty())

            <div class="empty">
                Belum ada pesanan yang selesai.
            </div>

        @else

            @foreach($riwayatSaya as $pesanan)
                <div class="card">
                    <div class="card-top">
                        <div class="kode">{{ $pesanan->kode_pesanan }}</div>
                        <span class="status-badge">Selesai</span>
                    </div>

                    @foreach($pesanan->detailPesanan as $detail)
                        <div class="cart-item">
                            <div>
                                {{ $detail->qty }}x {{ $detail->menu->nama_menu }}
                                @if($detail->level_gula)
                                    <div class="ket">{{ $detail->level_gula }}, {{ $detail->level_es }}</div>
                                @endif
                            </div>
                            <div>Rp {{ number_format($detail->subtotal,0,',','.') }}</div>
                        </div>

                        @if($detail->rating)
                            <div class="rating-block">
                                <div class="rating-stars-static">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $detail->rating->bintang ? 'filled' : '' }}">&#9733;</span>
                                    @endfor
                                </div>
                                @if($detail->rating->komentar)
                                    <div class="rating-comment">"{{ $detail->rating->komentar }}"</div>
                                @endif
                            </div>
                        @else
                            <div class="rating-block">
                                <form action="{{ route('order.rating.store', $meja->kode_qr) }}" method="POST" class="form-rating">
                                    @csrf
                                    <input type="hidden" name="detail_pesanan_id" value="{{ $detail->id }}">
                                    <div class="rating-label">Gimana rasanya {{ $detail->menu->nama_menu }}? Kasih rating yuk!</div>
                                    <div class="rating-stars-input" data-rating-input>
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="star-btn" data-value="{{ $i }}">&#9733;</span>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="bintang" class="bintang-input">
                                    <textarea name="komentar" placeholder="Saran atau komentar (opsional)" maxlength="500"></textarea>
                                    <button type="submit" class="btn-kirim-rating">Kirim Rating</button>
                                </form>
                            </div>
                        @endif
                    @endforeach

                    <div class="total-row">
                        <span>Total</span>
                        <span>Rp {{ number_format($pesanan->total,0,',','.') }}</span>
                    </div>
                </div>
            @endforeach

        @endif
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

        document.querySelectorAll('[data-rating-input]').forEach(function (container) {
            const stars = container.querySelectorAll('.star-btn');
            const hiddenInput = container.closest('form').querySelector('.bintang-input');

            stars.forEach(function (star) {
                star.addEventListener('click', function () {
                    const value = parseInt(this.dataset.value);
                    hiddenInput.value = value;

                    stars.forEach(function (s) {
                        s.classList.toggle('active', parseInt(s.dataset.value) <= value);
                    });
                });
            });
        });

        document.querySelectorAll('.form-rating').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                const bintang = form.querySelector('.bintang-input').value;
                if (!bintang) {
                    e.preventDefault();
                    alert('Silakan pilih rating bintang terlebih dahulu.');
                }
            });
        });
    </script>

</body>
</html>