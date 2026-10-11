@extends('layouts.main')
@section('title', 'Edit Menu')

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i> Edit Menu
        </h3>
    </div>

    <form action="{{ route('admin.menu.update', $menu->id) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="card-body p-4">

            <!-- Alert Error -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <strong>Ada kesalahan!</strong> Periksa kembali form di bawah.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">

                <!-- Kolom Kiri -->
                <div class="col-md-8">

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Nama Menu</label>
                        <input type="text"
                            name="nama_menu"
                            class="form-control @error('nama_menu') is-invalid @enderror"
                            placeholder="Masukkan nama menu"
                            value="{{ old('nama_menu', $menu->nama_menu) }}"
                            required>
                        @error('nama_menu')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Kategori</label>
                        <select name="kategori_menu_id"
                            class="form-control @error('kategori_menu_id') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('kategori_menu_id', $menu->kategori_menu_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_menu_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Deskripsi</label>
                        <textarea name="deskripsi"
                            rows="3"
                            class="form-control @error('deskripsi') is-invalid @enderror"
                            placeholder="Masukkan deskripsi menu">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-4">

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Harga</label>
                        <input type="text"
                            id="harga"
                            name="harga"
                            class="form-control @error('harga') is-invalid @enderror"
                            placeholder="Masukkan harga"
                            value="{{ old('harga', number_format($menu->harga, 0, ',', '.')) }}"
                            required>
                        @error('harga')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Stok</label>
                        <input type="text"
                            id="stok"
                            name="stok"
                            class="form-control @error('stok') is-invalid @enderror"
                            placeholder="Masukkan stok"
                            value="{{ old('stok', number_format($menu->stok, 0, ',', '.')) }}"
                            required>
                        @error('stok')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Gambar Menu</label>
                        @if($menu->gambar)
                            <div class="mb-2">
                                <img src="{{ asset('uploads/menu/'.$menu->gambar) }}"
                                    width="100"
                                    class="img-thumbnail">
                                <br>
                                <small class="text-muted">Gambar saat ini</small>
                            </div>
                        @endif
                        <input type="file"
                            name="gambar"
                            class="form-control @error('gambar') is-invalid @enderror">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                        @error('gambar')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Status</label>
                        <select name="status"
                            class="form-control @error('status') is-invalid @enderror"
                            required>
                            <option value="tersedia" {{ old('status', $menu->status) == 'tersedia' ? 'selected' : '' }}>
                                Tersedia
                            </option>
                            <option value="habis" {{ old('status', $menu->status) == 'habis' ? 'selected' : '' }}>
                                Habis
                            </option>
                        </select>
                        @error('status')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

            </div>

        </div>

        <!-- FOOTER — tombol digabung berdekatan di kiri -->
        <div class="card-footer d-flex justify-content-start" style="gap: 10px;">
            <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                 Update
            </button>
        </div>

    </form>

</div>

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    function formatRibuan(idInput) {
        const input = document.getElementById(idInput);

        input.addEventListener('input', function () {
            let angka = this.value.replace(/\D/g, '');
            this.value = new Intl.NumberFormat('id-ID').format(angka);
        });
    }

    formatRibuan('harga');
    formatRibuan('stok');

});
</script>
@endsection

@endsection