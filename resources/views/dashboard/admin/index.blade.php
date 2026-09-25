@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')

<div class="row">

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalMenu }}</h3>
                <p>Total Menu</p>
            </div>
            <div class="icon">
                <i class="fas fa-utensils"></i>
            </div>
            <a href="{{ route('admin.menu.index') }}" class="small-box-footer">
                Lihat Menu
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalMeja }}</h3>
                <p>Total Meja</p>
            </div>
            <div class="icon">
                <i class="fas fa-chair"></i>
            </div>
            <a href="{{ route('admin.meja.index') }}" class="small-box-footer">
                Lihat Meja
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalPesanan }}</h3>
                <p>Total Pesanan</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ route('admin.pesanan.index') }}" class="small-box-footer">
                Lihat Pesanan
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>Rp {{ number_format($totalPendapatan,0,',','.') }}</h3>
                <p>Total Pendapatan</p>
            </div>
            <div class="icon">
                <i class="fas fa-wallet"></i>
            </div>
            <a href="{{ route('admin.laporan') }}" class="small-box-footer">
                 Detail Pendapatan
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-8">

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
                                    <a href="{{ route('admin.pesanan.show', $item->id) }}" class="btn btn-info btn-sm">
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

    </div>

    <div class="col-md-4">

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="fas fa-chart-pie"></i>

                    Status Pesanan

                </h3>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <td>Menunggu</td>
                        <td><span class="badge badge-warning">{{ $statusMenunggu }}</span></td>
                    </tr>

                    <tr>
                        <td>Berhasil</td>
                        <td><span class="badge badge-success">{{ $statusBerhasil }}</span></td>
                    </tr>

                    <tr>
                        <td>Dibatalkan</td>
                        <td><span class="badge badge-danger">{{ $statusDibatalkan }}</span></td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection