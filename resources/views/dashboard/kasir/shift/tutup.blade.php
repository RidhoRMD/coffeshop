<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutup Shift</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card-shift {
            background: #fff;
            border-radius: 16px;
            padding: 36px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .header-shift { text-align: center; margin-bottom: 24px; }
        .icon-wrap {
            width: 64px;
            height: 64px;
            background: #fdecea;
            color: #d32f2f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 16px;
        }
        h2 { margin-bottom: 6px; color: #333; }
        p.sub { color: #888; font-size: 13px; }

        .ringkasan {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
        }
        .ringkasan-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 13px;
        }
        .ringkasan-row.total {
            border-top: 1px dashed #ddd;
            margin-top: 6px;
            padding-top: 10px;
            font-weight: 700;
            font-size: 14px;
        }
        .ringkasan-row .label { color: #666; }
        .ringkasan-row .value { font-weight: 600; color: #333; }

        label { display: block; text-align: left; font-weight: 600; font-size: 13px; margin-bottom: 8px; color: #555; }
        input[type="text"], textarea {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1.5px solid #e0e0e0;
            font-size: 15px;
            margin-bottom: 18px;
            font-family: inherit;
        }
        textarea { resize: vertical; min-height: 60px; }

        #kembalian-info {
            text-align: center;
            padding: 10px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 18px;
            display: none;
        }
        #kembalian-info.lebih { background: #d4edda; color: #155724; display: block; }
        #kembalian-info.kurang { background: #fdecea; color: #b71c1c; display: block; }
        #kembalian-info.pas { background: #e2e3e5; color: #383d41; display: block; }

        .btn-tutup {
            width: 100%;
            background: #d32f2f;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
        }
        .alert-error {
            background: #fdecea;
            color: #b71c1c;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
            text-align: left;
        }
    </style>
</head>
<body>

    <div class="card-shift">
        <div class="header-shift">
            <div class="icon-wrap"><i class="fas fa-door-closed"></i></div>
            <h2>Tutup Shift</h2>
            <p class="sub">Cocokkan uang fisik di laci sebelum menutup shift</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <div class="ringkasan">
            <div class="ringkasan-row">
                <span class="label">Modal Awal</span>
                <span class="value">Rp {{ number_format($shiftAktif->modal_awal,0,',','.') }}</span>
            </div>
            <div class="ringkasan-row">
                <span class="label">Total Transaksi</span>
                <span class="value">{{ $totalTransaksi }}x</span>
            </div>
            <div class="ringkasan-row">
                <span class="label">Penjualan Tunai</span>
                <span class="value">Rp {{ number_format($totalTunai,0,',','.') }}</span>
            </div>
            <div class="ringkasan-row">
                <span class="label">Penjualan QRIS</span>
                <span class="value">Rp {{ number_format($totalQris,0,',','.') }}</span>
            </div>
            <div class="ringkasan-row total">
                <span class="label">Uang Seharusnya di Laci</span>
                <span class="value">Rp {{ number_format($uangSeharusnya,0,',','.') }}</span>
            </div>
        </div>

        <form action="{{ route('kasir.shift.tutup.proses') }}" method="POST">
            @csrf

            <label>Uang Fisik di Laci (Rp)</label>
            <input type="text" id="uang_fisik_display" placeholder="Hitung uang di laci" inputmode="numeric" autocomplete="off" required autofocus>
            <input type="hidden" name="uang_fisik" id="uang_fisik">

            <div id="kembalian-info"></div>

            <label>Catatan (opsional)</label>
            <textarea name="catatan" placeholder="Contoh: selisih karena kembalian salah hitung"></textarea>

            <button type="submit" class="btn-tutup">
                <i class="fas fa-door-closed"></i> Tutup Shift
            </button>
        </form>
    </div>

    <script>
        const uangSeharusnya = {{ $uangSeharusnya }};

        document.getElementById('uang_fisik_display').addEventListener('input', function () {
            let raw = this.value.replace(/\D/g, '');
            document.getElementById('uang_fisik').value = raw;
            this.value = raw ? parseInt(raw).toLocaleString('id-ID') : '';

            const info = document.getElementById('kembalian-info');
            if (raw === '') {
                info.className = '';
                info.style.display = 'none';
                return;
            }

            const selisih = parseInt(raw) - uangSeharusnya;

            if (selisih === 0) {
                info.textContent = 'Pas, tidak ada selisih';
                info.className = 'pas';
            } else if (selisih > 0) {
                info.textContent = 'Lebih Rp ' + selisih.toLocaleString('id-ID');
                info.className = 'lebih';
            } else {
                info.textContent = 'Kurang Rp ' + Math.abs(selisih).toLocaleString('id-ID');
                info.className = 'kurang';
            }
        });
    </script>

</body>
</html>