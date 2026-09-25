@extends('layouts.main')
@section('title', 'Meja')

@section('content')

<div class="card">

    <div class="card-header d-flex">

        <h3 class="card-title">
            <i class="fas fa-chair"></i>
            Data Meja
        </h3>

        <a href="{{ route('admin.meja.create') }}"
            class="btn btn-primary ml-auto">

            <i class="fas fa-plus"></i>
            Tambah Meja

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

            <i class="fas fa-chair"></i>

            Total Meja :

            <strong>{{ $meja->count() }}</strong>

        </div>

        <table id="example1" class="table table-bordered table-hover">

            <thead>

                <tr>

                    <th width="5%">No</th>
                    <th>Nomor Meja</th>
                    <th>Kode QR</th>
                    <th>Status</th>
                    <th width="20%">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($meja as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>

                        Meja {{ $item->nomor_meja }}

                    </td>

                    <td>

                        <span class="badge badge-dark">

                            {{ $item->kode_qr }}

                        </span>

                    </td>

                    <td>

                        @if($item->status == 'kosong')

                            <span class="badge badge-success">

                                Kosong

                            </span>

                        @elseif($item->status == 'dipesan')

                            <span class="badge badge-warning">

                                Terisi

                            </span>

                        @else

                            <span class="badge badge-danger">

                                Nonaktif

                            </span>

                        @endif

                    </td>

                    <td>

                        {{-- Tombol QR --}}
                        <a href="{{ route('admin.meja.qrcode',$item->id) }}"
                            class="btn btn-info btn-sm"
                            title="Lihat QR Code">

                            <i class="fas fa-qrcode"></i>

                        </a>

                        <a href="{{ route('admin.meja.download',$item->id) }}"
                            class="btn btn-success btn-sm"
                            title="Download PNG">

                            <i class="fas fa-download"></i>

                        </a>
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.meja.edit',$item->id) }}"
                            class="btn btn-warning btn-sm">

                            <i class="fas fa-edit"></i>

                        </a>

                        {{-- Tombol Hapus --}}
                        <form
                            action="{{ route('admin.meja.delete',$item->id) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                             <button type="button"
                                onclick="confirmDeleteForm(this.closest('form'), 'Hapus meja ini?', 'Data yang dihapus tidak bisa dikembalikan.')"
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