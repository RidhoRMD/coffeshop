@extends('layouts.main')
@section('title', 'Voucher')

@section('content')

<div class="card">

    <div class="card-header d-flex">
        <h3 class="card-title">
            <i class="fas fa-ticket-alt"></i>
            Data Voucher
        </h3>

        <a href="{{ route('admin.voucher.create') }}" class="btn btn-primary ml-auto">
            <i class="fas fa-plus"></i> Tambah Voucher
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table id="example1" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Tipe Diskon</th>
                    <th>Nilai</th>
                    <th>Min. Belanja</th>
                    <th>Pemakaian</th>
                    <th>Expired</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($voucher as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge badge-dark">{{ $item->kode }}</span></td>
                    <td>{{ $item->tipe_diskon == 'persen' ? 'Persen' : 'Nominal' }}</td>
                    <td>
                        {{ $item->tipe_diskon == 'persen' ? $item->nilai_diskon.'%' : 'Rp '.number_format($item->nilai_diskon,0,',','.') }}
                    </td>
                    <td>{{ $item->minimal_belanja ? 'Rp '.number_format($item->minimal_belanja,0,',','.') : '-' }}</td>
                    <td>{{ $item->jumlah_terpakai }} / {{ $item->batas_pemakaian ?? '∞' }}</td>
                    <td>{{ $item->tanggal_expired->format('d/m/Y') }}</td>
                    <td>
                        @if($item->status == 'aktif')
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.voucher.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.voucher.delete', $item->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button
                                type="button"
                                onclick="confirmDeleteForm(this.closest('form'), 'Hapus voucher \'{{ $item->kode }}\'?', 'Voucher yang dihapus tidak bisa dikembalikan.')"
                                class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada voucher.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

@endsection