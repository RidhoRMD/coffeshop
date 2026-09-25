@extends('layouts.main')

@section('title', 'Pembayaran')

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-cash-register"></i>
            Pembayaran - {{ $pesanan->kode_pesanan }}
        </h3>
    </div>

    <div class="card-body">

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered">
            <tr>
                <th width="30%">Jenis Pesanan</th>
               <td>
                    @switch($pesanan->jenis_pesanan)
                        @case('dine_in')
                            Dine In
                            @break
                        @case('dine_in_qr')
                            Dine In (Scan QR)
                            @break
                        @default
                            Take Away
                    @endswitch
                    @if($pesanan->meja)
                        - Meja {{ $pesanan->meja->nomor_meja }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>Total Bayar</th>
                <td><h4 class="text-success"><strong>Rp {{ number_format($pesanan->total,0,',','.') }}</strong></h4></td>
            </tr>
        </table>

        <hr>

        <ul class="nav nav-tabs" id="metode-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab-tunai">
                    <i class="fas fa-money-bill-wave"></i> Tunai
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-qris">
                    <i class="fas fa-qrcode"></i> QRIS
                </a>
            </li>
        </ul>

        <div class="tab-content border border-top-0 p-3">

            {{-- TAB TUNAI --}}
            <div class="tab-pane fade show active" id="tab-tunai">

                <form action="{{ route('kasir.pesanan.bayar.proses', $pesanan->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="metode" value="tunai">

                    <div class="form-group">
                        <label class="font-weight-bold">Uang Diterima</label>
                        <input type="text" id="uang_dibayar_display" class="form-control" placeholder="0" inputmode="numeric" autocomplete="off" required>
                        <input type="hidden" name="uang_dibayar" id="uang_dibayar">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Kembalian</label>
                        <h5 id="kembalian" class="text-primary">Rp 0</h5>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg btn-block">
                        <i class="fas fa-check-circle"></i> Konfirmasi Bayar Tunai
                    </button>
                </form>

            </div>

            {{-- TAB QRIS --}}
            <div class="tab-pane fade" id="tab-qris">

                <div class="text-center">
                    <h6>Scan QRIS untuk Membayar</h6>
                    <img src="{{ asset('images/qris-static.png') }}" alt="QRIS" style="max-width: 280px;" class="img-fluid my-3">
                    <p class="text-muted">Setelah customer selesai membayar, klik tombol di bawah.</p>

                    <form action="{{ route('kasir.pesanan.bayar.proses', $pesanan->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="metode" value="QRIS">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-check-circle"></i> Konfirmasi Pembayaran QRIS
                        </button>
                    </form>
                </div>

            </div>

        </div>

        <a href="{{ route('kasir.pesanan.show', $pesanan->id) }}" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

    </div>

</div>

@endsection

@section('js')
<script>
document.getElementById('uang_dibayar_display').addEventListener('input', function () {
    // Ambil angka murni aja (buang semua karakter selain digit)
    let raw = this.value.replace(/\D/g, '');

    // Simpan nilai asli (tanpa titik) ke hidden input untuk dikirim ke server
    document.getElementById('uang_dibayar').value = raw;

    // Format tampilan dengan titik ribuan
    this.value = raw ? parseInt(raw).toLocaleString('id-ID') : '';

    // Hitung kembalian
    const total = {{ $pesanan->total }};
    const dibayar = parseInt(raw) || 0;
    const kembalian = dibayar - total;

    document.getElementById('kembalian').textContent =
        'Rp ' + (kembalian > 0 ? kembalian.toLocaleString('id-ID') : '0');
});
</script>
@endsection