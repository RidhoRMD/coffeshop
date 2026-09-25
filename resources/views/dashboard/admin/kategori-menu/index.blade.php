@extends('layouts.main')
@section('title', 'Kategori Menu')

@section('content')

<div class="card">

        <div class="card-header d-flex">
        <h3 class="card-title">
            <i class="fas fa-list"></i> Data Kategori Menu
        </h3>

        <a href="{{ route('admin.kategori-menu.create') }}"
        class="btn btn-primary ml-auto">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="alert alert-info">

            <i class="fas fa-folder-open"></i>

            Total Kategori :
            <strong>{{ $kategori->count() }}</strong>

        </div>

        <table id="example1" class="table table-bordered table-hover">

            <thead>

                <tr>

                    <th width="5%">No</th>
                    <th>Nama Kategori</th>
                    <th width="20%">Tanggal Dibuat</th>
                    <th width="15%">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($kategori as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>

                            @php

                                $badge = 'info';

                                switch ($item->nama_kategori) {

                                    case 'Kopi':
                                        $badge = 'dark';
                                        break;

                                    case 'Non Kopi':
                                        $badge = 'success';
                                        break;

                                    case 'Snack':
                                        $badge = 'warning';
                                        break;

                                    case 'Dessert':
                                        $badge = 'danger';
                                        break;

                                }

                            @endphp

                            <span class="badge badge-{{ $badge }}">
                                {{ $item->nama_kategori }}
                            </span>

                        </td>

                        <td>

                            {{ $item->created_at->format('d M Y') }}

                        </td>

                        <td>

                            <a href="{{ route('admin.kategori-menu.edit',$item->id) }}"
                                class="btn btn-warning btn-sm">

                                <i class="fas fa-edit"></i>

                            </a>

                            <form
                                action="{{ route('admin.kategori-menu.delete',$item->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    onclick="confirmDeleteForm(this.closest('form'), 'Hapus kategori ini?', 'Data yang dihapus tidak bisa dikembalikan.')"
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