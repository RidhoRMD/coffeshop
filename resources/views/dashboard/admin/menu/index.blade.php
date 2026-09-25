@extends('layouts.main')
@section('title', 'Menu')

@section('content')

<div class="card">

    <div class="card-header d-flex">

        <h3 class="card-title">
            <i class="fas fa-mug-hot"></i>
            Data Menu
        </h3>

        <a href="{{ route('admin.menu.create') }}"
            class="btn btn-primary ml-auto">

            <i class="fas fa-plus"></i>
            Tambah Menu

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

            <i class="fas fa-utensils"></i>

            Total Menu :

            <strong>{{ $menu->count() }}</strong>

        </div>

        <table id="example1" class="table table-bordered table-hover">

            <thead>

                <tr>

                    <th width="5%">No</th>
                    <th>Gambar</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th width="15%">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($menu as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td width="100">

                            @if ($item->gambar)

                                <img src="{{ asset('uploads/menu/'.$item->gambar) }}"
                                    width="70"
                                    class="img-thumbnail">

                            @else

                                <span class="text-secondary">
                                    Belum Ada
                                </span>

                            @endif

                        </td>

                        <td>{{ $item->nama_menu }}</td>

                        <td>

                            <span class="badge badge-info">

                                {{ $item->kategori->nama_kategori }}

                            </span>

                        </td>

                        <td>

                            Rp {{ number_format($item->harga,0,',','.') }}

                        </td>

                       <td>
                            {{ number_format($item->stok, 0, ',', '.') }}
                        </td>

                        <td>
                            @if($item->status == 'tersedia')

                                <span class="badge badge-success">

                                    Tersedia

                                </span>

                            @else

                                <span class="badge badge-danger">

                                    Habis

                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('admin.menu.edit',$item->id) }}"
                                class="btn btn-warning btn-sm">

                                <i class="fas fa-edit"></i>

                            </a>

                            <form
                                action="{{ route('admin.menu.delete',$item->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    onclick="confirmDeleteForm(this.closest('form'), 'Hapus menu ini?', 'Data yang dihapus tidak bisa dikembalikan.')"
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