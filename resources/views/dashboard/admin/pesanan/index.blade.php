@extends('layouts.main')
@section('title', 'Pesanan')

@section('content')

<style>
    /* Matiin search box bawaan DataTables — dipindah manual ke baris filter tanggal */
    #example1_filter { display: none !important; }
</style>

<div class="card">

    <div class="card-header d-flex">

        <h3 class="card-title">

            <i class="fas fa-shopping-cart"></i>
            Data Pesanan

        </h3>

    </div>

    <div class="card-body">

        @if(session('success'))

            <div class="alert alert-success">

                <i class="fas fa-check-circle"></i>

                {{ session('success') }}

            </div>

        @endif

        <div class="alert alert-info">

            <i class="fas fa-shopping-bag"></i>

            Total Pesanan :

            <strong>{{ $pesanan->count() }}</strong>

        </div>

        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 10px;">

            <form action="{{ route('admin.pesanan.index') }}" method="GET" class="form-inline" id="form-pesanan" style="gap: 8px; flex-wrap: wrap;">

                <div class="form-group mr-2 mb-0">
                    <label for="dari_tanggal" class="mr-2">Dari</label>
                    <input type="date" name="dari_tanggal" id="dari_tanggal"
                        class="form-control" value="{{ $dariTanggal }}">
                </div>

                <div class="form-group mr-2 mb-0">
                    <label for="sampai_tanggal" class="mr-2">Sampai</label>
                    <input type="date" name="sampai_tanggal" id="sampai_tanggal"
                        class="form-control" value="{{ $sampaiTanggal }}">
                </div>

                <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary ml-2">
                    Hari Ini
                </a>

            </form>

            <div class="form-group mb-0 d-flex align-items-center">
                <label class="mr-2 mb-0" style="white-space: nowrap;">Search:</label>
                <input type="search" id="custom-search-pesanan" class="form-control" style="width: 220px;">
            </div>

        </div>

        <table id="example1" class="table table-bordered table-hover">

            <thead>

                <tr>

                    <th width="5%">No</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Jenis</th>
                    <th>Meja</th>
                    <th>Kasir</th>
                    <th>Barista</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th width="14%">Aksi</th>

                </tr>

            </thead>

            <tbody>

                    @foreach($pesanan as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                <td>

                    <span class="badge badge-dark">

                            {{ $item->kode_pesanan }}

                        </span>

                    </td>

                    <td>

                        {{ $item->created_at->format('d M Y, H:i') }}

                    </td>

                    <td>

                        {{ $item->nama_customer ?? '-' }}

                    </td>

                                        <td>

                        @switch($item->jenis_pesanan)

                            @case('dine_in')

                                <span class="badge badge-primary">Dine In</span>

                                @break

                            @case('dine_in_qr')

                                <span class="badge badge-purple" style="background:#6f42c1;color:#fff;">Dine In (QR)</span>

                                @break

                            @default

                                <span class="badge badge-secondary">Take Away</span>

                        @endswitch

                    </td>

                    <td>

                        @if($item->meja)

                            Meja {{ $item->meja->nomor_meja }}

                        @else

                            -

                        @endif

                    </td>

                    <td>

                        {{ $item->shift?->kasir?->name ?? '-' }}

                    </td>
                    <td>
                        {{ $item->barista?->name ?? '-' }}
                    </td>

                    <td>

                        Rp {{ number_format($item->total,0,',','.') }}

                    </td>

                    <td>

                        @switch($item->status_pesanan)

                            @case('baru')

                                <span class="badge badge-warning">Baru</span>

                                @break

                            @case('sedang_dibuat')

                                <span class="badge badge-info">Sedang Dibuat</span>

                                @break

                            @case('siap_disajikan')

                                <span class="badge badge-primary">Siap Disajikan</span>

                                @break

                            @case('siap_diambil')

                                <span class="badge badge-success">Siap Diambil</span>

                                @break

                            @case('selesai')

                                <span class="badge badge-dark">Selesai</span>

                                @break

                        @endswitch

                    </td>

                    <td>

                        @if($item->status_pembayaran == 'berhasil')

                            <span class="badge badge-success">

                                Berhasil

                            </span>

                        @elseif($item->status_pembayaran == 'dibatalkan')

                            <span class="badge badge-danger">

                                Dibatalkan

                            </span>

                        @else

                            <span class="badge badge-warning">

                                Menunggu

                            </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('admin.pesanan.show',$item->id) }}"
                            class="btn btn-info btn-sm">

                            <i class="fas fa-eye"></i>

                        </a>

                        <form action="{{ route('admin.pesanan.delete', $item->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                           <button type="button"
                            onclick="confirmDeleteForm(this.closest('form'), 'Hapus pesanan ini?', 'Data yang dihapus tidak bisa dikembalikan.')"
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

@section('js')
<script>
    document.getElementById('custom-search-pesanan').addEventListener('keyup', function () {
        $('#example1').DataTable().search(this.value).draw();
    });

    // Sementara pakai input tanggal bawaan browser (bukan library luar),
    // tapi tetap auto-submit begitu tanggal "Sampai" diganti -- jadi
    // tombol Filter tidak diperlukan lagi.
    $('#sampai_tanggal').on('change', function () {
        $('#form-pesanan').submit();
    });

    // Kalau "Dari" diubah jadi lebih besar dari "Sampai", ikut update
    // "Sampai" dulu baru submit, biar rentangnya tetap masuk akal.
    $('#dari_tanggal').on('change', function () {
        var dari = $(this).val();
        var sampai = $('#sampai_tanggal').val();
        if (dari && sampai && dari > sampai) {
            $('#sampai_tanggal').val(dari);
        }
        $('#form-pesanan').submit();
    });
</script>
    @include('dashboard.bagian.auto-refresh', ['urlCek' => route('admin.pesanan.cek-pembaruan')])
@endsection