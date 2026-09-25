@extends('layouts.main')
@section('title', 'Pesanan')

@section('content')

<div class="card">

    <div class="card-header d-flex">

        <h3 class="card-title">

            <i class="fas fa-shopping-cart"></i>
            Data Pesanan

        </h3>

    </div>

    <div class="card-body">

        @if(session('success'))

            <div class="alert alert-success">

                <i class="fas fa-check-circle"></i>

                {{ session('success') }}

            </div>

        @endif

        <div class="alert alert-info">

            <i class="fas fa-shopping-bag"></i>

            Total Pesanan :

            <strong>{{ $pesanan->count() }}</strong>

        </div>

        <table id="example1" class="table table-bordered table-hover">

            <thead>

                <tr>

                    <th width="5%">No</th>
                    <th>Kode</th>
                    <th>Customer</th>
                    <th>Jenis</th>
                    <th>Meja</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th width="18%">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($pesanan as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>

                        <span class="badge badge-dark">

                            {{ $item->kode_pesanan }}

                        </span>

                    </td>

                    <td>

                        {{ $item->nama_customer ?? '-' }}

                    </td>

                    <td>

                        @switch($item->jenis_pesanan)

                            @case('dine_in')
                                <span class="badge badge-primary">Dine In</span>
                                @break

                            @case('dine_in_qr')
                                <span class="badge" style="background-color:#6f42c1; color:#fff;">
                                    <i class="fas fa-qrcode"></i> Dine in (QR)
                                </span>
                                @break

                            @default
                                <span class="badge badge-secondary">Take Away</span>

                        @endswitch

                    </td>

                    <td>

                        @if($item->meja)

                            Meja {{ $item->meja->nomor_meja }}

                        @else

                            -

                        @endif

                    </td>

                    <td>

                        Rp {{ number_format($item->total,0,',','.') }}

                    </td>

                    <td>

                        @switch($item->status_pesanan)

                            @case('baru')

                                <span class="badge badge-warning">Baru</span>

                                @break

                            @case('sedang_dibuat')

                                <span class="badge badge-info">Sedang Dibuat</span>

                                @break

                            @case('siap_disajikan')

                                <span class="badge badge-primary">Siap Disajikan</span>

                                @break

                            @case('siap_diambil')

                                <span class="badge badge-success">Siap Diambil</span>

                                @break

                            @case('selesai')

                                <span class="badge badge-dark">Selesai</span>

                                @break

                        @endswitch

                    </td>

                    <td>

                        @if($item->status_pembayaran == 'berhasil')

                            <span class="badge badge-success">

                                Berhasil

                            </span>

                        @elseif($item->status_pembayaran == 'dibatalkan')

                            <span class="badge badge-danger">

                                Dibatalkan

                            </span>

                        @else

                            <span class="badge badge-warning">

                                Menunggu

                            </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('kasir.pesanan.show',$item->id) }}"
                            class="btn btn-info btn-sm">
                            
                            <i class="fas fa-eye"></i>

                        </a>
                        
                        <a href="{{ route('kasir.pesanan.resi', $item->id) }}"
                            class="btn btn-secondary btn-sm"
                            title="Cetak Resi">

                            <i class="fas fa-print"></i>

                        </a>

                        @if($item->status_pesanan == 'baru' && $item->status_pembayaran == 'menunggu')

                            <form action="{{ route('kasir.pesanan.destroy', $item->id) }}"
                                method="POST"
                                style="display:inline-block"
                                onsubmit="return confirm('Yakin ingin menghapus pesanan {{ $item->kode_pesanan }}?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </form>

                        @endif

                    </td>
                </tr>

                @empty

                <tr>

                    <td colspan="9" class="text-center">

                        Belum ada pesanan.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection