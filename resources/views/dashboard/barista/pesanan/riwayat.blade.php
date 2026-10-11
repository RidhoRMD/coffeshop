@extends('layouts.main')
@section('title', 'Riwayat Hari Ini')

@section('content')

<div class="card mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <p class="mb-0 text-muted">Total item selesai dibuat hari ini</p>
            <h2 class="mb-0">{{ $totalItem }} <small style="font-size: 16px;">porsi</small></h2>
        </div>
        <i class="fas fa-mug-hot fa-3x text-muted ml-auto"></i>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Rincian per Menu</h3>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th width="150">Jumlah Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ringkasan as $item)
                    <tr>
                        <td>{{ $item->menu->nama_menu ?? 'Menu telah dihapus' }}</td>
                        <td>{{ $item->total_qty }} porsi</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center text-muted">
                            Belum ada pesanan yang selesai hari ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection