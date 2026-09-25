@extends('layouts.main')
@section('title','Detail Pesanan')

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-receipt"></i>

            Detail Pesanan

        </h3>

    </div>

    <div class="card-body">

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        <div class="row">

            <div class="col-md-6">

                <table class="table table-bordered">

                    <tr>
                        <th width="40%">Kode Pesanan</th>
                        <td>{{ $pesanan->kode_pesanan }}</td>
                    </tr>

                    <tr>
                        <th>Tanggal Transaksi</th>
                        <td>{{ $pesanan->created_at->format('d M Y, H:i') }}</td>
                    </tr>

                    <tr>
                        <th>Customer</th>
                        <td>{{ $pesanan->nama_customer ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Ditangani Kasir</th>
                        <td>{{ $pesanan->shift?->kasir?->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Ditangani Barista</th>
                        <td>{{ $pesanan->barista?->name ?? '-' }}</td>
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

                            {{ $pesanan->meja ? 'Meja '.$pesanan->meja->nomor_meja : '-' }}

                        </td>
                    </tr>

                    <tr>
                        <th>Total</th>
                        <td>

                            Rp {{ number_format($pesanan->total,0,',','.') }}

                        </td>
                    </tr>

                </table>

            </div>

            <div class="col-md-6">

                <form action="{{ route('admin.pesanan.update',$pesanan->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="form-group">

                        <label>Status Pesanan</label>

                        <select
                            name="status_pesanan"
                            class="form-control">

                            <option value="baru" @selected($pesanan->status_pesanan=='baru')>

                                Baru

                            </option>

                            <option value="sedang_dibuat" @selected($pesanan->status_pesanan=='sedang_dibuat')>

                                Sedang Dibuat

                            </option>

                            <option value="siap_disajikan" @selected($pesanan->status_pesanan=='siap_disajikan')>

                                Siap Disajikan

                            </option>

                            <option value="siap_diambil" @selected($pesanan->status_pesanan=='siap_diambil')>

                                Siap Diambil

                            </option>

                            <option value="selesai" @selected($pesanan->status_pesanan=='selesai')>

                                Selesai

                            </option>

                        </select>

                    </div>

                    <button class="btn btn-primary">

                        <i class="fas fa-save"></i>

                        Simpan Status

                    </button>

                </form>

            </div>

        </div>

        <hr>

        <h5>

            Daftar Menu

        </h5>

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <th>Catatan</th>

                </tr>

            </thead>

            <tbody>

                @forelse($pesanan->detailPesanan as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->menu->nama_menu }}</td>

                    <td>{{ $item->qty }}</td>

                    <td>

                        Rp {{ number_format($item->harga,0,',','.') }}

                    </td>

                    <td>

                        Rp {{ number_format($item->subtotal,0,',','.') }}

                    </td>

                    <td>

                        @if($item->level_gula)

                            <span class="badge badge-info">{{ $item->level_gula }}</span>
                            <span class="badge badge-primary">{{ $item->level_es }}</span>

                        @else

                            -

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">

                        Belum ada detail pesanan.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="card-footer">

        <a href="{{ route('admin.pesanan.index') }}"
            class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>

@endsection