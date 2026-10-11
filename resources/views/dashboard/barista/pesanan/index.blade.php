@extends('layouts.main')
@section('title', 'Pesanan Masuk')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row">
    @forelse($pesanan as $item)
        @php
            $labelStatus = [
                'baru'           => ['Baru', 'badge-warning'],
                'sedang_dibuat'  => ['Sedang Dibuat', 'badge-info'],
                'siap_disajikan' => ['Siap Disajikan', 'badge-primary'],
                'siap_diambil'   => ['Siap Diambil', 'badge-primary'],
                'selesai'        => ['Selesai', 'badge-success'],
            ];

            $labelTombol = [
                'baru'           => 'Mulai Buat',
                'sedang_dibuat'  => in_array($item->jenis_pesanan, ['dine_in', 'dine_in_qr']) ? 'Siap Disajikan' : 'Siap Diambil',
                'siap_disajikan' => 'Selesai',
                'siap_diambil'   => 'Selesai',
            ];

            [$labelText, $labelClass] = $labelStatus[$item->status_pesanan] ?? ['-', 'badge-secondary'];
        @endphp

        <div class="col-md-4 mb-4">
            <div class="card h-100">
               <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Pesanan #{{ $item->kode_pesanan }}</strong>
                    <span class="badge {{ $labelClass }}">{{ $labelText }}</span>
                </div>

                <div class="card-body">
                    <p class="mb-1 text-muted" style="font-size: 12px;">
                        <i class="far fa-clock"></i> Masuk {{ $item->created_at->diffForHumans() }}
                    </p>

                    <p class="mb-1">
                         @if(in_array($item->jenis_pesanan, ['dine_in', 'dine_in_qr']))
                            <i class="fas fa-chair"></i> Dine In - Meja {{ $item->meja->nomor_meja ?? '-' }}
                        @else
                            <i class="fas fa-shopping-bag"></i> Take Away
                        @endif
                    </p>

                    @if($item->nama_customer)
                        <p class="mb-2 text-muted">Customer: {{ $item->nama_customer }}</p>
                    @endif

                    <hr class="my-2">

                    <ul class="list-unstyled mb-0">
                        @foreach($item->detailPesanan as $detail)
                            <li>
                                {{ $detail->qty }}x {{ $detail->menu->nama_menu ?? '-' }}
                                @if($detail->level_gula || $detail->level_es)
                                    <br><small class="text-danger font-weight-bold">
                                        ({{ $detail->level_gula }}, {{ $detail->level_es }})
                                    </small>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card-footer">
                    @if(isset($labelTombol[$item->status_pesanan]))
                        <form action="{{ route('barista.pesanan.status', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ $labelTombol[$item->status_pesanan] }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                Belum ada pesanan masuk.
            </div>
        </div>
    @endforelse
</div>

@endsection

@section('js')
    @include('dashboard.bagian.auto-refresh', ['urlCek' => route('barista.pesanan.cek-pembaruan')])
@endsection