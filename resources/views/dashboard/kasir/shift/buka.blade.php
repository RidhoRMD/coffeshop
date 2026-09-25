<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buka Shift</title>
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
        }
        .card-shift {
            background: #fff;
            border-radius: 16px;
            padding: 36px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            text-align: center;
        }
        .icon-wrap {
            width: 64px;
            height: 64px;
            background: #e3f2fd;
            color: #1976d2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 16px;
        }
        h2 { margin-bottom: 6px; color: #333; }
        p.sub { color: #888; font-size: 13px; margin-bottom: 24px; }
        label { display: block; text-align: left; font-weight: 600; font-size: 13px; margin-bottom: 8px; color: #555; }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1.5px solid #e0e0e0;
            font-size: 15px;
            margin-bottom: 20px;
        }
        .btn-buka {
            width: 100%;
            background: #1976d2;
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
        <div class="icon-wrap"><i class="fas fa-cash-register"></i></div>
        <h2>Buka Shift</h2>
        <p class="sub">Masukkan modal awal kas sebelum mulai bekerja</p>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('kasir.shift.buka.proses') }}" method="POST">
            @csrf
            <label>Modal Awal (Rp)</label>
            <input type="text" id="modal_awal_display" placeholder="Contoh: 500.000" inputmode="numeric" autocomplete="off" required autofocus>
            <input type="hidden" name="modal_awal" id="modal_awal">

            <button type="submit" class="btn-buka">
                <i class="fas fa-play"></i> Mulai Shift
            </button>
        </form>

        <script>
            document.getElementById('modal_awal_display').addEventListener('input', function () {
                let raw = this.value.replace(/\D/g, '');
                document.getElementById('modal_awal').value = raw;
                this.value = raw ? parseInt(raw).toLocaleString('id-ID') : '';
            });
        </script>
    </div>

</body>
</html>