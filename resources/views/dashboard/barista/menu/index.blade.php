@extends('layouts.main')
@section('title', 'Status Menu')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="rr-confirm-overlay show" id="rrErrorModal">
        <div class="rr-confirm-box">
            <div class="rr-confirm-icon" style="background: rgba(229,57,53,0.1); color:#E53935;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h4>Gagal Menyimpan</h4>
            <p>
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </p>
            <div class="rr-confirm-actions">
                <button type="button" class="rr-confirm-ok" style="flex:1;" onclick="document.getElementById('rrErrorModal').classList.remove('show')">
                    Mengerti
                </button>
            </div>
        </div>
    </div>
@endif


<div class="card">
    <div class="card-header">
        <h3 class="card-title">Status Ketersediaan Menu</h3>
    </div>
        <div class="card-body">
        <div class="table-responsive">
       <table class="table table-hover text-nowrap" style="min-width: 560px; width: 100%;">
    <thead>
        <tr>
            <th>Menu</th>
            <th>Kategori</th>
            <th class="text-center">Stok</th>
            <th>Status</th>
            <th class="text-center" style="width: 140px;">Aksi</th>
        </tr>
    </thead>
            <tbody>
                @foreach($menu as $item)
                    <tr>
                        <td>{{ $item->nama_menu }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ number_format($item->stok, 0, ',', '.') }}</td>
                        <td>
                            @if($item->status === 'tersedia')
                                <span class="badge badge-success">Tersedia</span>
                            @else
                                <span class="badge badge-danger">Habis</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-block"
                                data-toggle="modal" data-target="#modalStok{{ $item->id }}">
                                <i class="fas fa-edit"></i> Edit Stok
                            </button>
                        </td>
                    </tr>
                     @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Semua modal dirender di LUAR tabel, biar HTML valid & lebar kolom gak berantakan --}}
@foreach($menu as $item)
    <div class="modal fade" id="modalStok{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('barista.menu.update-stok', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Stok - {{ $item->nama_menu }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label class="fw-semibold">Jumlah Stok</label>
                        <input type="text"
                            class="form-control input-stok"
                            name="stok"
                            value="{{ number_format($item->stok, 0, ',', '.') }}"
                            required>
                        <small class="text-muted d-block mt-2">
                            Isi <strong>0</strong> untuk menandai menu ini otomatis Habis. Maksimal 500.
                        </small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.input-stok').forEach(function (input) {
        input.addEventListener('input', function () {
            let angka = this.value.replace(/\D/g, '');

            if (angka === '') {
                this.value = '';
                return;
            }

            let num = parseInt(angka, 10);
            if (num > 500) {
                num = 500;
            }

            this.value = new Intl.NumberFormat('id-ID').format(num);
        });
    });
});
</script>
@endsection

@endsection