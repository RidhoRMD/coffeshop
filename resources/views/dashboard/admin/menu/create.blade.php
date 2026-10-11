@extends('layouts.main')
@section('title','Tambah Menu')

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            Tambah Menu

        </h3>

    </div>

    <form action="{{ route('admin.menu.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="card-body">

            <div class="form-group">

                <label>Nama Menu</label>

                <input
                    type="text"
                    name="nama_menu"
                    class="form-control">

            </div>

            <div class="form-group">

                <label>Kategori</label>

                <select
                    name="kategori_menu_id"
                    class="form-control">

                    <option value="">-- Pilih Kategori --</option>

                    @foreach($kategori as $item)

                        <option value="{{ $item->id }}">

                            {{ $item->nama_kategori }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

                <label>Deskripsi</label>

                <textarea
                    name="deskripsi"
                    rows="3"
                    class="form-control"></textarea>

            </div>

            <div class="form-group">

                <label>Harga</label>

                <input
                type="text"
                id="harga"
                name="harga"
                class="form-control"
                placeholder="Masukkan harga"
                required>

            </div>

            <div class="form-group">

                <label>Stok</label>

                <input
                type="text"
                id="stok"
                name="stok"
                class="form-control"
                placeholder="Masukkan stok">

            </div>

            <div class="form-group">

                <label>Gambar Menu</label>

                <input
                    type="file"
                    name="gambar"
                    class="form-control">

            </div>

            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control">

                    <option value="tersedia">

                        Tersedia

                    </option>

                    <option value="habis">

                        Habis

                    </option>

                </select>

            </div>

        </div>

        <div class="card-footer">
            <a href="{{ route('admin.menu.index') }}"
                class="btn btn-secondary">
                Kembali
            </a>
            
             <button class="btn btn-primary">
                Simpan
            </button>

        </div>

    </form>

</div>

@endsection
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