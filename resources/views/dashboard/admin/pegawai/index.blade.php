@extends('layouts.main')

@section('title', 'Kelola Pegawai')

@section('content')

<div class="card">

    <div class="card-header d-flex">

        <h3 class="card-title">

            <i class="fas fa-users-cog"></i>

            Kelola Pegawai

        </h3>

        <a href="{{ route('admin.pegawai.create') }}"
            class="btn btn-primary ml-auto">

            <i class="fas fa-plus"></i>

            Tambah Pegawai

        </a>

    </div>

    <div class="card-body">

        @if(session('success'))

            <div class="alert alert-success">

                <i class="fas fa-check-circle"></i>

                {{ session('success') }}

            </div>

        @endif

        <div class="alert alert-info">

            <i class="fas fa-users"></i>

            Total Pegawai :

            <strong>{{ $pegawai->count() }}</strong>

        </div>

        <table id="example1" class="table table-bordered table-hover">

           <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Terakhir Login</th>
                    <th width="18%">Aksi</th>
                </tr>
            </thead>

                        <tbody>

                @foreach ($pegawai as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->name }}</td>

                    <td>{{ $item->email }}</td>

                    <td>

                        @if($item->role == 'admin')

                            <span class="badge badge-danger">
                                Admin
                            </span>

                        @elseif($item->role == 'kasir')

                            <span class="badge badge-success">
                                Kasir
                            </span>

                        @else

                            <span class="badge badge-info">
                                Barista
                            </span>

                        @endif

                    </td>

                    <td>

                        @if($item->status == 'aktif')

                            <span class="badge badge-success">
                                Aktif
                            </span>

                        @else

                            <span class="badge badge-secondary">
                                Nonaktif
                            </span>

                        @endif

                    </td>

                    <td>

                        @if($item->last_login)

                            {{ \Carbon\Carbon::parse($item->last_login)->format('d/m/Y H:i') }}

                        @else

                            <span class="text-muted">
                                Belum Pernah Login
                            </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('admin.pegawai.show', $item->id) }}"
                            class="btn btn-info btn-sm"
                            title="Detail">

                            <i class="fas fa-eye"></i>

                        </a>

                        <a href="{{ route('admin.pegawai.edit', $item->id) }}"
                            class="btn btn-warning btn-sm"
                            title="Edit">

                            <i class="fas fa-edit"></i>

                        </a>

                        <form
                            action="{{ route('admin.pegawai.delete', $item->id) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                           <button type="button"
                                onclick="confirmDeleteForm(this.closest('form'), 'Hapus pegawai ini?', 'Data yang dihapus tidak bisa dikembalikan.')"
                                class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection