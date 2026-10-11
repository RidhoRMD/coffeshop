@extends('layouts.main')

@section('title', 'Tambah Pegawai')

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            Tambah Pegawai

        </h3>

    </div>

    @if ($errors->any())

        <div class="alert alert-danger m-3">

            <strong>Terjadi kesalahan!</strong>

            <ul class="mb-0 mt-2">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form action="{{ route('admin.pegawai.store') }}" method="POST">

        @csrf

        <div class="card-body">

            <div class="form-group">

                <label>Nama Pegawai</label>

                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    required>

            </div>

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    required>

            </div>

            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required>

                <small class="text-muted">

                    Password minimal 6 karakter.

                </small>

            </div>

            <div class="form-group">

                <label>Konfirmasi Password</label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    required>

            </div>

            <div class="form-group">

                <label>Role</label>

                <select
                    name="role"
                    class="form-control @error('role') is-invalid @enderror"
                    required>

                    <option value="">-- Pilih Role --</option>

                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>
                        Kasir
                    </option>

                    <option value="barista" {{ old('role') == 'barista' ? 'selected' : '' }}>
                        Barista
                    </option>

                </select>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control @error('status') is-invalid @enderror"
                    required>

                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                        Nonaktif
                    </option>

                </select>

            </div>

        </div>

        <div class="card-footer">
            <a href="{{ route('admin.pegawai.index') }}"
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