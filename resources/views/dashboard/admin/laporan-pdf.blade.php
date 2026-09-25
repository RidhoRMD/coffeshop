<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { margin-bottom: 4px; }
        .periode { color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #f0f0f0; }
        .ringkasan { display: table; width: 100%; margin-bottom: 20px; }
        .ringkasan-item { display: table-cell; width: 33%; padding: 10px; border: 1px solid #ccc; }
        .ringkasan-item .label { font-size: 10px; color: #888; }
        .ringkasan-item .value { font-size: 16px; font-weight: bold; }
        .section-title { font-weight: bold; margin: 16px 0 8px; }
    </style>
</head>
<body>

    <h2>Laporan Penjualan</h2>
    <div class="periode">Periode: {{ \Carbon\Carbon::parse($dariTanggal)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($sampaiTanggal)->format('d/m/Y') }}</div>

    <div class="ringkasan">
        <div class="ringkasan-item">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $totalTransaksi }}</div>
        </div>
        <div class="ringkasan-item">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($totalPendapatan,0,',','.') }}</div>
        </div>
        <div class="ringkasan-item">
            <div class="label">Rata-rata per Transaksi</div>
            <div class="value">Rp {{ number_format($rataRata,0,',','.') }}</div>
        </div>
    </div>

    <div class="section-title">Metode Pembayaran</div>
    <table>
        <tr><th>Metode</th><th>Jumlah</th><th>Total</th></tr>
        @forelse($metodeBayar as $m)
        <tr>
            <td>{{ strtoupper($m->metode) }}</td>
            <td>{{ $m->jumlah }}x</td>
            <td>Rp {{ number_format($m->total,0,',','.') }}</td>
        </tr>
        @empty
        <tr><td colspan="3">Tidak ada data.</td></tr>
        @endforelse
    </table>

    <div class="section-title">Jenis Pesanan</div>
    <table>
        <tr><th>Jenis</th><th>Jumlah</th></tr>
        @forelse($jenisPesanan as $j)
        <tr>
            <td>
                @switch($j->jenis_pesanan)
                    @case('dine_in')
                        Dine In (Kasir)
                        @break
                    @case('dine_in_qr')
                        Dine In (Scan QR)
                        @break
                    @default
                        Take Away
                @endswitch
            </td>
            <td>{{ $j->jumlah }}x</td>
        </tr>
        @empty
        <tr><td colspan="2">Tidak ada data.</td></tr>
        @endforelse
    </table>

    <div class="section-title">Menu Terlaris</div>
    <table>
        <tr><th>Menu</th><th>Terjual</th></tr>
        @forelse($menuTerlaris as $mt)
        <tr>
            <td>{{ $mt->menu->nama_menu ?? '-' }}</td>
            <td>{{ $mt->total_qty }}</td>
        </tr>
        @empty
        <tr><td colspan="2">Tidak ada data.</td></tr>
        @endforelse
    </table>

    <div class="section-title">Rincian Transaksi</div>
    <table>
        <tr>
            <th>Kode</th><th>Tanggal</th><th>Customer</th><th>Jenis</th><th>Meja</th><th>Total</th>
        </tr>
        @forelse($transaksi as $item)
        <tr>
            <td>{{ $item->kode_pesanan }}</td>
            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $item->nama_customer ?? '-' }}</td>
             <td>
                @switch($item->jenis_pesanan)
                    @case('dine_in')
                        Dine In
                        @break
                    @case('dine_in_qr')
                        Dine In (Scan QR)
                        @break
                    @default
                        Take Away
                @endswitch
            </td>
            <td>{{ $item->meja ? 'Meja '.$item->meja->nomor_meja : '-' }}</td>
            <td>Rp {{ number_format($item->total,0,',','.') }}</td>
        </tr>
        @empty
        <tr><td colspan="6">Tidak ada transaksi.</td></tr>
        @endforelse
    </table>

</body>
</html>