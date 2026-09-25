@extends('layouts.main')

@section('title', 'Detail Pesanan')

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-receipt"></i>
            Detail Pesanan
        </h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="25%">Kode Pesanan</th>
                <td>{{ $pesanan->kode_pesanan }}</td>
            </tr>

            <tr>
                <th>Jenis Pesanan</th>
                <td>

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

                </td>
            </tr>

            <tr>
                <th>Meja</th>
                <td>

                    @if($pesanan->meja)

                        Meja {{ $pesanan->meja->nomor_meja }}
                        <span class="text-muted">({{ $pesanan->meja->status == 'dipesan' ? 'Dipesan' : 'Kosong' }})</span>

                    @else

                        -

                    @endif

                </td>
            </tr>

            <tr>
                <th>Nama Customer</th>
                <td>
                    {{ $pesanan->nama_customer ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Status Pesanan</th>
                <td>

                    @switch($pesanan->status_pesanan)

                        @case('baru')
                            Baru
                            @break

                        @case('sedang_dibuat')
                            Sedang Dibuat
                            @break

                        @case('siap_disajikan')
                            Siap Disajikan
                            @break

                        @case('siap_diambil')
                            Siap Diambil
                            @break

                        @case('selesai')
                            Selesai
                            @break

                    @endswitch

                </td>
            </tr>

            <tr>
                <th>Status Pembayaran</th>
                <td>

                    @if($pesanan->status_pembayaran == 'berhasil')

                        Berhasil

                    @elseif($pesanan->status_pembayaran == 'dibatalkan')

                        Dibatalkan

                    @else

                        Menunggu

                    @endif

                </td>
            </tr>

            <tr>
                <th>Metode Pembayaran</th>
                <td>

                    @if($pesanan->pembayaran)

                        @if(strtoupper($pesanan->pembayaran->metode) == 'QRIS')

                            <i class="fas fa-qrcode"></i> QRIS

                        @else

                            <i class="fas fa-money-bill-wave"></i> Tunai

                        @endif

                        @if($pesanan->pembayaran->status_pembayaran == 'lunas')

                            <span class="ml-2">
                                <i class="fas fa-check-circle"></i> Pembayaran Berhasil
                            </span>

                        @endif

                    @else

                        <span class="text-muted">-</span>

                    @endif

                </td>
            </tr>

            <tr>
                <th>Total</th>
                <td>

                    <strong>

                        Rp {{ number_format($pesanan->total,0,',','.') }}

                    </strong>

                </td>
            </tr>

        </table>

        <hr>

        <h5>Daftar Menu</h5>

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Menu</th>
                    <th width="10%">Qty</th>
                    <th width="20%">Harga</th>
                    <th width="20%">Subtotal</th>

                </tr>

            </thead>

            <tbody>

                @foreach($pesanan->detailPesanan as $detail)

                <tr>

                    <td>
                        {{ $detail->menu->nama_menu ?? '-' }}
                        @if($detail->level_gula || $detail->level_es)
                            <br><small class="text-muted">{{ $detail->level_gula }}, {{ $detail->level_es }}</small>
                        @endif
                    </td>

                    <td>{{ $detail->qty }}</td>

                    <td>
                        Rp {{ number_format($detail->harga,0,',','.') }}
                    </td>

                    <td>
                        Rp {{ number_format($detail->subtotal,0,',','.') }}
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

                       @if($pesanan->meja)

            <hr>

            @if($pesanan->meja->status == 'dipesan' && $isPesananAktifDiMeja)

            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#modalKosongkanMeja">
                <i class="fas fa-broom"></i>
                Kosongkan Meja {{ $pesanan->meja->nomor_meja }}
            </button>

            <div class="modal fade" id="modalKosongkanMeja" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-broom text-danger"></i>
                                Kosongkan Meja
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Yakin customer di <strong>Meja {{ $pesanan->meja->nomor_meja }}</strong> sudah pergi?
                            Meja ini akan dikosongkan dan bisa dipakai pesanan baru.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <form action="{{ route('kasir.pesanan.kosongkan-meja', $pesanan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-broom"></i>
                                    Ya, Kosongkan Meja
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($pesanan->meja->status == 'dipesan' && !$isPesananAktifDiMeja)

                <button class="btn btn-outline-secondary" disabled>
                    <i class="fas fa-history"></i>
                    Meja {{ $pesanan->meja->nomor_meja }} Sudah Dipakai Pesanan Lain
                </button>

            @else

                <button class="btn btn-outline-secondary" disabled>
                    <i class="fas fa-check"></i>
                    Meja {{ $pesanan->meja->nomor_meja }} Sudah Dikosongkan
                </button>

            @endif

        @endif

    </div>

    <div class="card-footer">

        <a href="{{ route('kasir.pesanan.index') }}"
            class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>
            Kembali

        </a>

        @if($pesanan->status_pembayaran == 'menunggu')

            <a href="{{ route('kasir.pesanan.bayar', $pesanan->id) }}"
                class="btn btn-success float-right">

                <i class="fas fa-money-bill-wave"></i>
                Bayar

            </a>

        @else

            <button class="btn btn-success float-right" disabled>

                <i class="fas fa-check-circle"></i>
                Sudah Dibayar

            </button>

        @endif

    </div>

</div>

@endsection