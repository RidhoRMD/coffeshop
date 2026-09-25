@extends('layouts.main')
@section('title', 'Tambah Voucher')

@section('content')

<div class="row">

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus"></i> Tambah Voucher Baru</h3>
            </div>

            <div class="card-body">

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('admin.voucher.store') }}" method="POST" id="form-voucher">
                    @csrf

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Kode Voucher</label>
                            <input type="text" name="kode" class="form-control" placeholder="Contoh: DISKON50" value="{{ old('kode') }}" maxlength="20" required style="text-transform:uppercase;">
                            <small class="text-muted">Kode unik voucher (huruf besar, maks 20 karakter). Kode ini juga yang akan tampil ke customer.</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Tipe Diskon</label>
                            <select name="tipe_diskon" id="tipe_diskon" class="form-control" required>
                                <option value="persen">Persentase (%)</option>
                                <option value="nominal">Nominal (Rp)</option>
                            </select>
                            <small class="text-muted" id="hint-tipe">Persentase: 1% - 100%</small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label id="label-nilai">Nilai Diskon (%)</label>
                            <input type="text" id="nilai_diskon_display" class="form-control" placeholder="0" inputmode="numeric" autocomplete="off" required>
                            <input type="hidden" name="nilai_diskon" id="nilai_diskon">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Minimal Pembelian</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="text" id="minimal_belanja_display" class="form-control" placeholder="0" inputmode="numeric" autocomplete="off" required>
                                <input type="hidden" name="minimal_belanja" id="minimal_belanja">
                            </div>
                            <small class="text-muted">Rp 10.000 - Rp 100.000</small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Kuota Penggunaan</label>
                            <input type="text" id="batas_pemakaian_display" class="form-control" placeholder="0" inputmode="numeric" autocomplete="off">
                            <input type="hidden" name="batas_pemakaian" id="batas_pemakaian">
                            <small class="text-muted">0 = unlimited, maksimal 1.000</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}" required>
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Tanggal Kadaluarsa</label>
                            <input type="date" name="tanggal_expired" class="form-control" value="{{ old('tanggal_expired') }}" required>
                        </div>
                    </div>

                    <a href="{{ route('admin.voucher.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>

                </form>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header" style="background-color:#1A120B; color:#fff;">
                <h3 class="card-title"><i class="fas fa-info-circle"></i> Panduan</h3>
            </div>
            <div class="card-body">
                <p><strong>Tipe Diskon:</strong></p>
                <ul>
                    <li><strong>Persentase:</strong> 1% - 100%</li>
                    <li><strong>Nominal:</strong> Rp 10.000 - Rp 500.000</li>
                </ul>
                <p><strong>Batasan:</strong></p>
                <ul>
                    <li>Minimal pembelian: Rp 10.000 - Rp 100.000</li>
                    <li>Kuota: maksimal 1.000 (0 = unlimited)</li>
                </ul>
                <p><strong>Contoh:</strong></p>
                <div class="border rounded p-2 mb-2">
                    <strong>DISKON100</strong><br>
                    Nilai: 100%<br>
                    Belanja Rp 100.000 → <strong>GRATIS</strong>
                </div>
                <div class="border rounded p-2 mb-2">
                    <strong>DISKON50RIBU</strong><br>
                    Tipe: Nominal, Nilai: Rp 50.000<br>
                    Belanja Rp 100.000 → Diskon <strong>Rp 50.000</strong>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('js')
<script>
    const tipeSelect = document.getElementById('tipe_diskon');
    const nilaiDisplay = document.getElementById('nilai_diskon_display');
    const nilaiHidden = document.getElementById('nilai_diskon');
    const labelNilai = document.getElementById('label-nilai');
    const hintTipe = document.getElementById('hint-tipe');

    function updateTipeDiskon() {
        nilaiDisplay.value = '';
        nilaiHidden.value = '';

        if (tipeSelect.value === 'persen') {
            labelNilai.textContent = 'Nilai Diskon (%)';
            hintTipe.textContent = 'Persentase: 1% - 100%';
            nilaiDisplay.placeholder = 'Contoh: 10';
        } else {
            labelNilai.textContent = 'Nilai Diskon (Rp)';
            hintTipe.textContent = 'Nominal: Rp 10.000 - Rp 500.000';
            nilaiDisplay.placeholder = 'Contoh: 50.000';
        }
    }
    tipeSelect.addEventListener('change', updateTipeDiskon);
    updateTipeDiskon();

    nilaiDisplay.addEventListener('input', function () {
        let raw = this.value.replace(/\D/g, '');
        let num = parseInt(raw || '0');

        if (tipeSelect.value === 'persen') {
            if (num > 100) num = 100;
            this.value = num || '';
            nilaiHidden.value = num;
        } else {
            if (num > 500000) num = 500000;
            this.value = num ? num.toLocaleString('id-ID') : '';
            nilaiHidden.value = num;
        }
    });

    function pasangFormatRupiah(displayId, hiddenId, maxVal) {
        const display = document.getElementById(displayId);
        const hidden = document.getElementById(hiddenId);

        display.addEventListener('input', function () {
            let raw = this.value.replace(/\D/g, '');
            let num = parseInt(raw || '0');
            if (maxVal && num > maxVal) num = maxVal;
            hidden.value = num;
            this.value = num ? num.toLocaleString('id-ID') : '';
        });
    }

    pasangFormatRupiah('minimal_belanja_display', 'minimal_belanja', 100000);
    pasangFormatRupiah('batas_pemakaian_display', 'batas_pemakaian', 1000);
</script>
@endsection