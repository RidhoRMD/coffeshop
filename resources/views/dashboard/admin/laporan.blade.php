@extends('layouts.main')
@section('title', 'Laporan Penjualan')

@section('content')

<style>
    /* Matiin search box bawaan DataTables — dipindah manual ke baris filter tanggal, sama kayak Pesanan */
    #tabel-rincian_filter { display: none !important; }
</style>

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-line"></i>
            Laporan Penjualan
        </h3>
    </div>

    <div class="card-body">

        <div class="row mb-4">

            <div class="col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalTransaksi }}</h3>
                        <p>Total Transaksi</p>
                    </div>
                    <div class="icon"><i class="fas fa-receipt"></i></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rp {{ number_format($totalPendapatan,0,',','.') }}</h3>
                        <p>Total Pendapatan</p>
                    </div>
                    <div class="icon"><i class="fas fa-wallet"></i></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>Rp {{ number_format($rataRata,0,',','.') }}</h3>
                        <p>Rata-rata per Transaksi</p>
                    </div>
                    <div class="icon"><i class="fas fa-calculator"></i></div>
                </div>
            </div>

        </div>

        <div class="row mb-4">

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Metode Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        @forelse($metodeBayar as $m)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ strtoupper($m->metode) }}</span>
                                <span>
                                    <strong>{{ $m->jumlah }}x</strong> —
                                    Rp {{ number_format($m->total,0,',','.') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Jenis Pesanan</h5>
                    </div>
                    <div class="card-body">
                        @forelse($jenisPesanan as $j)
                            <div class="d-flex justify-content-between mb-2">
                                <span>
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
                                </span>
                                <strong>{{ $j->jumlah }}x</strong>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Menu Terlaris</h5>
                    </div>
                    <div class="card-body">
                        @forelse($menuTerlaris as $mt)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $mt->menu->nama_menu ?? '-' }}</span>
                                <strong>{{ $mt->total_qty }} terjual</strong>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Penjualan per Kasir</h5>
                    </div>
                    <div class="card-body">
                        @forelse($perKasir as $pk)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $pk['nama'] }}</span>
                                <span>
                                    <strong>{{ $pk['jumlah'] }}x</strong> —
                                    Rp {{ number_format($pk['total'],0,',','.') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 10px;">

            <form method="GET" action="{{ route('admin.laporan') }}" class="form-inline" id="form-laporan" style="gap: 8px; flex-wrap: wrap;">

                <div class="form-group mr-2 mb-0">
                    <label for="dari_tanggal" class="mr-2">Dari</label>
                    <input type="date" name="dari_tanggal" id="dari_tanggal" value="{{ $dariTanggal }}" class="form-control">
                </div>
                <div class="form-group mr-2 mb-0">
                    <label for="sampai_tanggal" class="mr-2">Sampai</label>
                    <input type="date" name="sampai_tanggal" id="sampai_tanggal" value="{{ $sampaiTanggal }}" class="form-control">
                </div>

                <a href="{{ route('admin.laporan.pdf', ['dari_tanggal' => $dariTanggal, 'sampai_tanggal' => $sampaiTanggal]) }}"
                    class="btn btn-danger ml-2" target="_blank">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>

                <button type="button" class="btn btn-secondary ml-2" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
            </form>

            <div class="form-group mb-0 d-flex align-items-center">
                <label class="mr-2 mb-0" style="white-space: nowrap;">Search:</label>
                <input type="search" id="custom-search-rincian" class="form-control" style="width: 220px;">
            </div>

        </div>

        <h5 class="mb-2">Rincian Transaksi</h5>

        <table id="tabel-rincian" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Jenis</th>
                    <th>Meja</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge badge-dark">{{ $item->kode_pesanan }}</span></td>
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
                <tr>
                    <td colspan="7" class="text-center">Tidak ada transaksi pada rentang tanggal ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>
@section('css')
<style>
    @media print {
        .main-sidebar, .main-header, form, .btn, .content-header {
            display: none !important;
        }
        .content-wrapper {
            margin-left: 0 !important;
        }
    }
</style>
@endsection

@section('js')
<script>
    $(function () {
        $('#tabel-rincian').DataTable({
            pageLength: 10,
            lengthChange: false,
            language: {
                paginate: {
                    previous: 'Sebelumnya',
                    next: 'Berikutnya'
                },
                info: 'Menampilkan _START_ - _END_ dari _TOTAL_ transaksi',
                zeroRecords: 'Tidak ada transaksi yang cocok.',
                    emptyTable: 'Tidak ada transaksi pada rentang tanggal ini.'
            }
        });

        document.getElementById('custom-search-rincian').addEventListener('keyup', function () {
            $('#tabel-rincian').DataTable().search(this.value).draw();
        });

        // Sementara pakai input tanggal bawaan browser (bukan library luar),
        // tapi tetap auto-submit begitu tanggal "Sampai" diganti -- jadi
        // tombol Filter tidak diperlukan lagi.
        $('#sampai_tanggal').on('change', function () {
            $('#form-laporan').submit();
        });

        // Kalau "Dari" diubah jadi lebih besar dari "Sampai", ikut update
        // "Sampai" dulu baru submit, biar rentangnya tetap masuk akal.
        $('#dari_tanggal').on('change', function () {
            var dari = $(this).val();
            var sampai = $('#sampai_tanggal').val();
            if (dari && sampai && dari > sampai) {
                $('#sampai_tanggal').val(dari);
            }
            $('#form-laporan').submit();
        });
    });
</script>
@endsection

@endsection