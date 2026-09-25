<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Pelanggan - Raund Raund</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --dark: #291C0E;
            --brown: #6E473B;
            --tan: #A78D78;
            --cream: #E1D4C2;
            --bg: #FAF9F7;
            --shadow-sm: 0 4px 14px rgba(41,28,14,0.06);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: var(--dark); }
        a { text-decoration: none; }

        .navbar {
            background: rgba(250, 249, 247, 0.92);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 32px;
            position: sticky;
            top: 0;
            border-bottom: 1px solid rgba(41,28,14,0.06);
        }
        .navbar img { height: 40px; }
        .navbar .brand-text { font-size: 15px; font-weight: 600; }
        .navbar .kembali {
            margin-left: auto;
            font-size: 13px;
            font-weight: 600;
            color: var(--brown);
        }

        main { max-width: 780px; margin: 0 auto; padding: 40px 24px 80px; }

        h1 { font-size: 28px; font-weight: 700; margin-bottom: 6px; }
        .subtitle { font-size: 13px; color: #9a8c7c; margin-bottom: 32px; }

        .breakdown {
            background: #fff;
            border-radius: 18px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 32px;
        }
        .breakdown-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 0;
            color: inherit;
        }
        .breakdown-label {
            width: 46px;
            font-size: 13px;
            font-weight: 600;
            flex-shrink: 0;
        }
        .breakdown-label i { color: #E0A527; font-size: 11px; }
        .breakdown-bar-track {
            flex: 1;
            height: 8px;
            background: #f0ede9;
            border-radius: 10px;
            overflow: hidden;
        }
        .breakdown-bar-fill {
            display: block;
            height: 100%;
            background: #E0A527;
            border-radius: 10px;
        }
        .breakdown-count {
            width: 32px;
            text-align: right;
            font-size: 12.5px;
            color: #9a8c7c;
            flex-shrink: 0;
        }
        .breakdown-row.active .breakdown-label,
        .breakdown-row.active .breakdown-count {
            color: var(--brown);
            font-weight: 700;
        }
        .filter-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            font-size: 13px;
            color: #6b5d4f;
        }
        .filter-info a { color: var(--brown); font-weight: 600; }

        .ulasan-card-full {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 16px;
        }
        .ulasan-user { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
        .ulasan-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: var(--brown); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 12.5px; flex-shrink: 0;
        }
        .ulasan-nama { font-size: 13.5px; font-weight: 600; }
        .ulasan-sub { font-size: 11.5px; color: #9a8c7c; }
        .ulasan-stars { margin-bottom: 10px; }
        .ulasan-stars .star { color: #E0A527; font-size: 14px; }
        .ulasan-stars .star.empty { color: #ddd; }
        .ulasan-komentar-full { font-size: 13px; line-height: 1.7; color: #6b5d4f; }

        .empty-state {
            text-align: center;
            color: #9a8c7c;
            font-size: 13.5px;
            padding: 60px 20px;
        }

        .pagination-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 24px;
        }
        .page-btn {
            font-size: 13px;
            font-weight: 600;
            color: var(--brown);
            padding: 8px 14px;
            border-radius: 10px;
            border: 1.5px solid #eee;
        }
        .page-btn.disabled { color: #ccc; pointer-events: none; }
        .page-info { font-size: 12.5px; color: #9a8c7c; }
    </style>
</head>
<body>

    <nav class="navbar">
        <img src="{{ asset('images/logo.webp') }}" alt="Raund Raund">
        <span class="brand-text">Raund Raund</span>
        <a href="{{ route('landing') }}" class="kembali">&larr; Kembali ke Beranda</a>
    </nav>

    <main>
        <h1>Ulasan Pelanggan</h1>
        <div class="subtitle">
            @if($totalRating > 0)
                Rata-rata {{ number_format($avgRating, 1) }} dari {{ $totalRating }} ulasan
            @else
                Belum ada ulasan
            @endif
        </div>

        @if($totalRating > 0)
            <div class="breakdown">
                @for($i = 5; $i >= 1; $i--)
                    @php
                        $count = $breakdown[$i] ?? 0;
                        $percent = $totalRating > 0 ? round($count / $totalRating * 100) : 0;
                        $isActive = (string) $filterBintang === (string) $i;
                    @endphp
                    <a href="{{ $isActive ? route('ulasan.index') : route('ulasan.index', ['bintang' => $i]) }}"
                       class="breakdown-row {{ $isActive ? 'active' : '' }}">
                        <span class="breakdown-label">{{ $i }} <i class="fas fa-star"></i></span>
                        <span class="breakdown-bar-track">
                            <span class="breakdown-bar-fill" style="width: {{ $percent }}%;"></span>
                        </span>
                        <span class="breakdown-count">{{ $count }}</span>
                    </a>
                @endfor
            </div>
        @endif

        @if($filterBintang)
            <div class="filter-info">
                <span>Menampilkan ulasan dengan {{ $filterBintang }} bintang</span>
                <a href="{{ route('ulasan.index') }}">Reset filter</a>
            </div>
        @endif

        @forelse($ulasan as $r)
            @php
                $namaCustomer = optional(optional($r->detailPesanan)->pesanan)->nama_customer ?: 'Pelanggan';
                $inisial = collect(explode(' ', $namaCustomer))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
            @endphp
            <div class="ulasan-card-full">
                <div class="ulasan-user">
                    <div class="ulasan-avatar">{{ $inisial }}</div>
                    <div>
                        <div class="ulasan-nama">{{ $namaCustomer }}</div>
                        <div class="ulasan-sub">{{ $r->menu->nama_menu ?? '-' }} &middot; {{ $r->created_at->format('d M Y') }}</div>
                    </div>
                </div>
                <div class="ulasan-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= $r->bintang ? '' : 'empty' }}">&#9733;</span>
                    @endfor
                </div>
                @if($r->komentar)
                    <p class="ulasan-komentar-full">{{ $r->komentar }}</p>
                @endif
            </div>
        @empty
            <div class="empty-state">
                Belum ada ulasan {{ $filterBintang ? 'dengan '.$filterBintang.' bintang' : '' }}.
            </div>
        @endforelse

        @if($ulasan->hasPages())
            <div class="pagination-nav">
                @if($ulasan->onFirstPage())
                    <span class="page-btn disabled">&larr; Sebelumnya</span>
                @else
                    <a href="{{ $ulasan->previousPageUrl() }}" class="page-btn">&larr; Sebelumnya</a>
                @endif

                <span class="page-info">Halaman {{ $ulasan->currentPage() }} dari {{ $ulasan->lastPage() }}</span>

                @if($ulasan->hasMorePages())
                    <a href="{{ $ulasan->nextPageUrl() }}" class="page-btn">Berikutnya &rarr;</a>
                @else
                    <span class="page-btn disabled">Berikutnya &rarr;</span>
                @endif
            </div>
        @endif
    </main>

</body>
</html>