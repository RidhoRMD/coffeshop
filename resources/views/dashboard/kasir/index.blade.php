@extends('layouts.main')
@section('title', 'Dashboard Kasir')

@section('content')

<div class="row">

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $pesananHariIni }}</h3>
                <p>Pesanan Hari Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ route('kasir.pesanan.index') }}" class="small-box-footer">
                Lihat Pesanan <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $menungguPembayaran }}</h3>
                <p>Menunggu Pembayaran</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('kasir.pesanan.index') }}" class="small-box-footer">
                Lihat Pesanan <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Rp {{ number_format($pendapatanHariIni,0,',','.') }}</h3>
                <p>Pendapatan Hari Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <span class="small-box-footer">&nbsp;</span>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $mejaTerisi }} / {{ $totalMeja }}</h3>
                <p>Meja Terisi</p>
            </div>
            <div class="icon">
                <i class="fas fa-chair"></i>
            </div>
            <span class="small-box-footer">&nbsp;</span>
        </div>
    </div>

</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-clock"></i>
            Pesanan Terbaru
        </h3>
    </div>
    <div class="card-body p-0">

        @if($pesananTerbaru->isEmpty())

            <p class="text-center text-muted p-3 mb-0">Belum ada pesanan.</p>

        @else

            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Jenis</th>
                        <th>Meja</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesananTerbaru as $item)
                    <tr>
                        <td><span class="badge badge-dark">{{ $item->kode_pesanan }}</span></td>
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
                        <td>
                            @if($item->status_pembayaran == 'berhasil')
                                <span class="badge badge-success">Berhasil</span>
                            @elseif($item->status_pembayaran == 'dibatalkan')
                                <span class="badge badge-danger">Dibatalkan</span>
                            @else
                                <span class="badge badge-warning">Menunggu</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('kasir.pesanan.show', $item->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        @endif

    </div>
</div>

@endsection

@section('js')
    @include('dashboard.bagian.auto-refresh', ['urlCek' => route('kasir.pesanan.cek-pembaruan'), 'tanda' => $signature])
@endsection