@extends('layouts.main')

@section('title', 'Edit Pegawai')

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            Edit Pegawai

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

    <form action="{{ route('admin.pegawai.update', $pegawai->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">

                <label>Nama Pegawai</label>

                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $pegawai->name) }}"
                    required>

            </div>

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $pegawai->email) }}"
                    required>

            </div>

            <div class="form-group">

                <label>Password Baru</label>

                <input
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror">

                <small class="text-muted">

                    Kosongkan jika tidak ingin mengganti password.
                    Jika diisi, minimal 6 karakter.

                </small>

            </div>

            <div class="form-group">

                <label>Role</label>

                <select
                    name="role"
                    class="form-control @error('role') is-invalid @enderror"
                    required>

                    <option value="admin"
                        {{ old('role', $pegawai->role) == 'admin' ? 'selected' : '' }}>

                        Admin

                    </option>

                    <option value="kasir"
                        {{ old('role', $pegawai->role) == 'kasir' ? 'selected' : '' }}>

                        Kasir

                    </option>

                    <option value="barista"
                        {{ old('role', $pegawai->role) == 'barista' ? 'selected' : '' }}>

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

                    <option value="aktif"
                        {{ old('status', $pegawai->status) == 'aktif' ? 'selected' : '' }}>

                        Aktif

                    </option>

                    <option value="nonaktif"
                        {{ old('status', $pegawai->status) == 'nonaktif' ? 'selected' : '' }}>

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
                <i class="fas fa-save"></i>
                Update
            </button>

        </div>

    </form>

</div>

@endsection