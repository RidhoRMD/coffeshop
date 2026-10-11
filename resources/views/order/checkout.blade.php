<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Meja {{ $meja->nomor_meja }}</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/logo.webp') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--dark);
        }

        .navbar {
            background: var(--dark);
            color: var(--cream);
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 0 24px;
            height: 60px;
        }

        .navbar-logo {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            font-weight: 700;
        }

        .table-badge {
            background: rgba(255, 255, 255, 0.15);
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        main {
            max-width: 500px;
            margin: 0 auto;
            padding: 24px;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            margin-bottom: 20px;
        }

        .card {
            background: var(--white);
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(41, 28, 14, 0.04);
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0ede9;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item .nama {
            font-weight: 600;
            font-size: 14px;
        }

        .cart-item .ket {
            font-size: 12px;
            color: #999;
        }

        .cart-total-row {
            display: flex;
            justify-content: space-between;
            font-weight: 800;
            font-size: 18px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 2px dashed #ddd;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 8px;
            color: var(--brown);
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1.5px solid #eee;
            font-size: 14px;
            font-family: inherit;
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
            margin-top: 12px;
            cursor: pointer;
        }

        .btn-full:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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

        .qr-wrapper {
            text-align: center;
        }

        .qr-wrapper img {
            max-width: 220px;
            margin: 16px auto;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
        }

        .status-menunggu {
            background: #fff3cd;
            color: #856404;
        }

        .status-lunas {
            background: #d4edda;
            color: #155724;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <nav class="navbar">

        <img src="{{ asset('images/logo.webp') }}"
            alt="Raund-Raund"
            style="height:36px; width:auto;">

        <div class="table-badge">
            Meja {{ $meja->nomor_meja }}
        </div>

    </nav>

    <main>

        <h2>Checkout</h2>

        <div id="alert-area"></div>

        @if(session('success'))
            <div style="
                background:#d4edda;
                color:#155724;
                padding:12px;
                border-radius:10px;
                margin-bottom:16px;
                font-size:13px;
            ">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif


        {{-- =========================
            DETAIL PESANAN
        ========================== --}}
        <div class="card">

            @foreach($cartItems as $item)

                <div class="cart-item">

                    <div>

                        <div class="nama">
                            {{ $item['qty'] }}x {{ $item['nama'] }}
                        </div>

                        @if($item['gula'])
                            <div class="ket">
                                {{ $item['gula'] }}, {{ $item['es'] }}
                            </div>
                        @endif

                    </div>

                    <div>
                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                    </div>

                </div>

            @endforeach


            @if($diskon > 0)

                <div class="cart-item" style="border-bottom:none;">

                    <div class="nama" style="color:#2e7d32;">
                        Diskon Voucher
                    </div>

                    <div style="color:#2e7d32;">
                        - Rp {{ number_format($diskon, 0, ',', '.') }}
                    </div>

                </div>

            @endif


            <div class="cart-total-row">

                <span>Total Bayar</span>

                <span>
                    Rp {{ number_format($totalAkhir, 0, ',', '.') }}
                </span>

            </div>

        </div>


        {{-- =========================
            VOUCHER
        ========================== --}}
        <div class="card">

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                gap:12px;
            ">

                <div>

                    <label style="margin-bottom:4px;">
                        Voucher
                    </label>

                    @if($voucher)

                        <div style="font-size:13px;">

                            <strong>
                                {{ $voucher->kode }}
                            </strong>

                            <br>

                            <span style="color:#999;">
                                {{ $voucher->nama_voucher }}
                            </span>

                        </div>

                    @else

                        <div style="font-size:13px; color:#999;">
                            Belum pakai voucher
                        </div>

                    @endif

                </div>


                @if($voucher)

                    <form
                        action="{{ route('order.voucher.remove', $meja->kode_qr) }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="btn-outline"
                            style="
                                padding:10px 16px;
                                margin:0;
                                white-space:nowrap;
                            "
                        >
                            Batalkan
                        </button>

                    </form>

                @else

                    <a
                        href="{{ route('order.voucher.list', $meja->kode_qr) }}"
                        class="btn-outline"
                        style="
                            padding:10px 16px;
                            margin:0;
                            white-space:nowrap;
                        "
                    >
                        Pilih Voucher
                    </a>

                @endif

            </div>

        </div>


        {{-- =========================
            NAMA CUSTOMER
        ========================== --}}
        <div class="card">

            <label for="nama_customer">
                Nama Kamu (opsional)
            </label>

            <input
                type="text"
                id="nama_customer"
                placeholder="Contoh: Budi"
            >

        </div>


        {{-- =========================
            QRIS
        ========================== --}}
        <div class="card" id="qris-card">

            <div id="area-belum-generate">

                <button
                    type="button"
                    class="btn-full"
                    id="btn-generate-qris"
                >
                    Bayar dengan QRIS
                </button>

            </div>


            <div
                id="area-qris"
                class="qr-wrapper"
                style="display:none;"
            >

                <img
                    id="qris-image"
                    src=""
                    alt="QR QRIS"
                >

                <div>

                    Status:

                    <span
                        id="qris-status-badge"
                        class="status-badge status-menunggu"
                    >
                        Menunggu Pembayaran
                    </span>

                </div>

            </div>

        </div>


        {{-- =========================
            KEMBALI
        ========================== --}}
        <a
            href="{{ route('order.index', $meja->kode_qr) }}"
            class="btn-outline"
        >
            Kembali ke Menu
        </a>

    </main>


    <script>

        let orderId = null;

        let pollInterval = null;

        // Menandakan pembayaran sudah lunas
        let sudahLunas = false;

        // Menandakan proses checkout sedang dikirim
        let sedangSubmitCheckout = false;


        /* =========================================================
           GENERATE QRIS
        ========================================================== */

        document
            .getElementById('btn-generate-qris')
            .addEventListener('click', function () {

                this.disabled = true;

                this.textContent = 'Membuat QR...';


                fetch(
                    "{{ route('order.qris.generate', $meja->kode_qr) }}",
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },

                        body: JSON.stringify({})
                    }
                )

                .then(res => res.json())

                .then(data => {

                    if (!data.success) {

                        tampilkanError(
                            'Gagal membuat QR: ' + data.message
                        );

                        this.disabled = false;

                        this.textContent = 'Bayar dengan QRIS';

                        return;
                    }


                    orderId = data.order_id;


                    document
                        .getElementById('area-belum-generate')
                        .style.display = 'none';


                    document
                        .getElementById('area-qris')
                        .style.display = '';


                    document
                        .getElementById('qris-image')
                        .src = data.qr_url;


                    // Mulai cek pembayaran
                    pollInterval = setInterval(
                        cekStatus,
                        3000
                    );

                })

                .catch(() => {

                    tampilkanError(
                        'Terjadi kesalahan saat menghubungi server pembayaran.'
                    );

                    this.disabled = false;

                    this.textContent = 'Bayar dengan QRIS';

                });

            });


        /* =========================================================
           CEK STATUS QRIS
        ========================================================== */

        function cekStatus() {

            // Kalau sudah lunas, jangan lakukan pengecekan lagi
            if (sudahLunas) {
                return;
            }


            fetch(
                `/order/qris/status/${orderId}`
            )

            .then(res => res.json())

            .then(data => {

                if (!data.success) {
                    return;
                }


                if (
                    data.transaction_status === 'settlement' ||
                    data.transaction_status === 'capture'
                ) {

                    // Pengaman tambahan agar submit hanya sekali
                    if (sudahLunas || sedangSubmitCheckout) {
                        return;
                    }


                    sudahLunas = true;

                    sedangSubmitCheckout = true;


                    clearInterval(pollInterval);


                    const badge =
                        document.getElementById(
                            'qris-status-badge'
                        );


                    badge.textContent =
                        'Lunas, menyimpan pesanan...';


                    badge.className =
                        'status-badge status-lunas';


                    submitCheckout();

                }

            })

            .catch(() => {

                if (!sudahLunas) {

                    tampilkanError(
                        'Gagal mengecek status pembayaran.'
                    );

                }

            });

        }


        /* =========================================================
           SIMPAN PESANAN
        ========================================================== */

        function submitCheckout() {

            // Jangan submit kalau pembayaran belum lunas
            if (!sudahLunas) {
                sedangSubmitCheckout = false;
                return;
            }


            // Pengaman agar tidak submit dua kali
            if (!sedangSubmitCheckout) {
                return;
            }


            const namaCustomer =
                document.getElementById(
                    'nama_customer'
                ).value;


            fetch(
                "{{ route('order.checkout', $meja->kode_qr) }}",
                {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                    body: JSON.stringify({

                        nama_customer:
                            namaCustomer,

                        qris_order_id:
                            orderId

                    })

                }
            )

            .then(async res => {

                /*
                 * Laravel biasanya mengembalikan redirect
                 * setelah pesanan berhasil dibuat.
                 */

                if (res.redirected) {

                    window.location.href =
                        res.url;

                    return;
                }


                /*
                 * Kalau bukan redirect, coba baca response.
                 */

                const text =
                    await res.text();


                try {

                    const data =
                        JSON.parse(text);

                    tampilkanError(
                        data.message ||
                        'Gagal menyimpan pesanan.'
                    );

                } catch {

                    tampilkanError(
                        'Gagal menyimpan pesanan.'
                    );

                }


                sedangSubmitCheckout = false;

            })

            .catch(() => {

                sedangSubmitCheckout = false;

                tampilkanError(
                    'Terjadi kesalahan saat menyimpan pesanan.'
                );

            });

        }


        /* =========================================================
           ERROR
        ========================================================== */

        function tampilkanError(msg) {

            document
                .getElementById('alert-area')
                .innerHTML = `
                    <div class="alert-error">
                        ${msg}
                    </div>
                `;

        }

    </script>

    @include('order.bagian.notifikasi-status', ['kodeQr' => $meja->kode_qr])
</body>
</html>