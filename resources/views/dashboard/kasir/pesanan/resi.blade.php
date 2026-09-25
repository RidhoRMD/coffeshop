<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resi - {{ $pesanan->kode_pesanan }}</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            background: #eee;
            margin: 0;
            padding: 20px;
        }
        .struk {
            width: 300px;
            margin: 0 auto;
            background: #fff;
            padding: 15px;
            font-size: 12px;
            line-height: 1.5;
        }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 2px 0;
            vertical-align: top;
        }
        .text-right { text-align: right; }
        .btn-cetak {
            display: block;
            width: 300px;
            margin: 15px auto 0;
            padding: 10px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-kembali {
            display: block;
            width: 300px;
            margin: 8px auto 0;
            padding: 10px;
            background: #6c757d;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
            text-decoration: none;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .struk {
                width: 100%;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="struk">

        <div class="center">
            <img src="{{ asset('images/logo.webp') }}" alt="Raund Raund" style="width:70px; height:auto; margin:0 auto 6px;">
        </div>
        <div class="center bold" style="font-size:14px;">
            RAUND-RAUND
        </div>
        <div class="center">
            Pekanbaru jl. Contoh Alamat No. 123<br>
            Telp: 0822-8851-2481
        </div>

        <hr>

        <table>
            <tr>
                <td>Kode</td>
                <td>: {{ $pesanan->kode_pesanan }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $pesanan->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>Jenis</td>
                <<td>
                    @switch($pesanan->jenis_pesanan)
                        @case('dine_in')
                            Dine In
                            @break
                        @case('dine_in_qr')
                            Dine In (Scan QR)
                            @break
                        @default
                            Take Away
                    @endswitch
                    @if($pesanan->meja)
                        - Meja {{ $pesanan->meja->nomor_meja }}
                    @endif
                </td>
            </tr>
            @if($pesanan->meja)
            <tr>
                <td>Meja</td>
                <td>: {{ $pesanan->meja->nomor_meja }}</td>
            </tr>
            @endif
            @if($pesanan->nama_customer)
            <tr>
                <td>Customer</td>
                <td>: {{ $pesanan->nama_customer }}</td>
            </tr>
            @endif
        </table>

        <hr>

        <table>
            @foreach($pesanan->detailPesanan as $detail)
            <tr>
                <td colspan="2">{{ $detail->menu->nama_menu }}</td>
            </tr>
            <tr>
                <td>{{ $detail->qty }} x {{ number_format($detail->harga,0,',','.') }}</td>
                <td class="text-right">{{ number_format($detail->subtotal,0,',','.') }}</td>
            </tr>
            @endforeach
        </table>

        <hr>

        <table>
            <tr class="bold">
                <td>TOTAL</td>
                <td class="text-right">Rp {{ number_format($pesanan->total,0,',','.') }}</td>
            </tr>
            <tr>
                <td>Metode</td>
                <td class="text-right">
                    {{ $pesanan->pembayaran ? strtoupper($pesanan->pembayaran->metode) : '-' }}
                </td>
            </tr>
            @if($pesanan->pembayaran && $pesanan->pembayaran->metode == 'tunai')
            <tr>
                <td colspan="2">
                    {{-- Kalau mau nampilin uang dibayar & kembalian di sini, perlu kolom tambahan di tabel pembayaran --}}
                </td>
            </tr>
            @endif
        </table>

        <hr>

        <div class="center">
            Terima kasih atas kunjungan Anda!<br>
            Selamat menikmati ☕
        </div>

    </div>

    <button class="btn-cetak no-print" onclick="window.print()">
        <i class="fas fa-print"></i> Cetak Struk
    </button>

    <a href="{{ route('kasir.pesanan.show', $pesanan->id) }}" class="btn-kembali no-print">
        Kembali
    </a>

</body>
</html>