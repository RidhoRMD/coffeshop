@extends('layouts.main')
@section('title', 'Tambah Kategori')

@section('content')

<div class="card">

    <div class="card-header">

        <h4>Tambah Kategori Menu</h4>

    </div>

    <form action="{{ route('admin.kategori-menu.store') }}" method="POST">

        @csrf

        <div class="card-body">

            <div class="form-group">

                <label>Nama Kategori</label>

                <input
                    type="text"
                    name="nama_kategori"
                    class="form-control @error('nama_kategori') is-invalid @enderror"
                    value="{{ old('nama_kategori') }}">

                @error('nama_kategori')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="perlu_kustomisasi" id="perlu_kustomisasi" value="1" checked>
                <label class="form-check-label" for="perlu_kustomisasi">
                    Kategori ini butuh pilihan gula/es? (khusus minuman)
                </label>
            </div>

        </div>

        <div class="card-footer">

            <a href="{{ route('admin.kategori-menu.index') }}"
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