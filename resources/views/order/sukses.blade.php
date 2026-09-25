<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil</title>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark: #291C0E;
            --brown: #6E473B;
            --tan: #A78D78;
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
        main {
            max-width: 480px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .sukses-icon {
            width: 80px;
            height: 80px;
            background: #d4edda;
            color: #155724;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 20px;
        }
        h1 {
            font-family: 'Poppins', sans-serif;
            text-align: center;
            margin-bottom: 6px;
        }
        .sub {
            text-align: center;
            color: #888;
            font-size: 14px;
            margin-bottom: 24px;
        }
        .card {
            background: var(--white);
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(41,28,14,0.04);
        }
        .row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }
        .row .label { color: #888; }
        .row .value { font-weight: 600; }
        .badge-kode {
            display: inline-block;
            background: var(--dark);
            color: #fff;
            padding: 6px 14px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 16px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0ede9;
            font-size: 14px;
        }
        .cart-item:last-child { border-bottom: none; }
        .cart-item .nama { font-weight: 600; }
        .cart-item .ket { font-size: 12px; color: #999; }
        .cart-total-row {
            display: flex;
            justify-content: space-between;
            font-weight: 800;
            font-size: 18px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 2px dashed #ddd;
        }
        .btn-full {
            width: 100%;
            background: var(--dark);
            color: #fff;
            border: none;
            border-radius: 14px;
            padding: 16px;
            font-weight: 700;
            font-size: 15px;
            text-align: center;
            text-decoration: none;
            display: block;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <main>
        <div class="sukses-icon">✓</div>
        <h1>Pesanan Berhasil!</h1>
        <p class="sub">Pembayaran kamu sudah kami terima</p>

        <div class="card" style="text-align:center;">
            <div class="badge-kode">{{ $pesanan->kode_pesanan }}</div>
        </div>

        <div class="card">
            <div class="row">
                <span class="label">Meja</span>
                <span class="value">Meja {{ $pesanan->meja->nomor_meja }}</span>
            </div>
            @if($pesanan->nama_customer)
            <div class="row">
                <span class="label">Nama</span>
                <span class="value">{{ $pesanan->nama_customer }}</span>
            </div>
            @endif
            <div class="row">
                <span class="label">Status</span>
                <span class="value">Menunggu Diproses</span>
            </div>
        </div>

        <div class="card">
            @foreach($pesanan->detailPesanan as $detail)
                <div class="cart-item">
                    <div>
                        <div class="nama">{{ $detail->qty }}x {{ $detail->menu->nama_menu }}</div>
                        @if($detail->level_gula)
                            <div class="ket">{{ $detail->level_gula }}, {{ $detail->level_es }}</div>
                        @endif
                    </div>
                    <div>Rp {{ number_format($detail->subtotal,0,',','.') }}</div>
                </div>
            @endforeach

            <div class="cart-total-row">
                <span>Total</span>
                <span>Rp {{ number_format($pesanan->total,0,',','.') }}</span>
            </div>
        </div>

        <a href="{{ route('order.index', $pesanan->meja->kode_qr) }}" class="btn-full">
            Pesan Lagi
        </a>
    </main>

</body>
</html>