@extends('layouts.main')

@section('title', 'Detail Pegawai')

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-user"></i>

            Detail Pegawai

        </h3>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>

                <th width="25%">Nama</th>

                <td>{{ $pegawai->name }}</td>

            </tr>

            <tr>

                <th>Email</th>

                <td>{{ $pegawai->email }}</td>

            </tr>

            <tr>

                <th>Role</th>

                <td>

                    @if($pegawai->role == 'admin')

                        <span class="badge badge-danger">

                            Admin

                        </span>

                    @elseif($pegawai->role == 'kasir')

                        <span class="badge badge-success">

                            Kasir

                        </span>

                    @else

                        <span class="badge badge-info">

                            Barista

                        </span>

                    @endif

                </td>

            </tr>

            <tr>

                <th>Status</th>

                <td>

                    @if($pegawai->status == 'aktif')

                        <span class="badge badge-success">

                            Aktif

                        </span>

                    @else

                        <span class="badge badge-secondary">

                            Nonaktif

                        </span>

                    @endif

                </td>

            </tr>

            <tr>

                <th>Dibuat Pada</th>

                <td>

                    {{ $pegawai->created_at->format('d F Y, H:i') }}

                </td>

            </tr>

            <tr>

                <th>Terakhir Diubah</th>

                <td>

                    {{ $pegawai->updated_at->format('d F Y, H:i') }}

                </td>

            </tr>

            <tr>

                <th>Terakhir Login</th>

                <td>

                    @if($pegawai->last_login)

                        {{ \Carbon\Carbon::parse($pegawai->last_login)->format('d F Y, H:i') }}

                    @else

                        <span class="text-muted">

                            Belum pernah login

                        </span>

                    @endif

                </td>

            </tr>

        </table>

    </div>

    <div class="card-footer">
        <a href="{{ route('admin.pegawai.index') }}"
            class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
        
        <a href="{{ route('admin.pegawai.edit', $pegawai->id) }}"
            class="btn btn-warning">
            Edit
        </a>

    </div>

</div>

@endsection