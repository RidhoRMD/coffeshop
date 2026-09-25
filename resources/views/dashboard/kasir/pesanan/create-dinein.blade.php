@extends('layouts.main')
@section('title', 'Pesanan Baru - Dine In')

@section('content')

<style>
    .pesanan-baru-page .info-card {
        background: #fff; border-radius: 16px; padding: 22px 24px;
        box-shadow: 0 4px 14px rgba(41,28,14,0.06); margin-bottom: 20px;
    }
    .pesanan-baru-page .info-card label {
        font-size: 12px; font-weight: 700; color: var(--dark, #291C0E);
        text-transform: uppercase; letter-spacing: .4px; margin-bottom: 6px; display: block;
    }
    .pesanan-baru-page .form-control {
        border-radius: 10px; border: 1.5px solid #eee; padding: 10px 14px; font-size: 14px;
    }
    .pesanan-baru-page .form-control:focus { border-color: var(--tan, #A78D78); box-shadow: none; }

    .pesanan-baru-page .menu-card-wrap {
        background: #fff; border-radius: 16px; padding: 20px;
        box-shadow: 0 4px 14px rgba(41,28,14,0.06);
    }
    .kategori-scroll-row { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 6px; margin-bottom: 18px; }
    .kategori-scroll-row::-webkit-scrollbar { display: none; }
    .kategori-btn {
        border: 1.5px solid #eee; background: #fff; color: #6b5d4f;
        padding: 8px 18px; border-radius: 100px; font-size: 12.5px; font-weight: 600;
        white-space: nowrap; cursor: pointer; transition: .2s; flex-shrink: 0;
    }
    .kategori-btn:hover { border-color: var(--tan, #A78D78); }
    .kategori-btn.active { background: var(--dark, #291C0E); border-color: var(--dark, #291C0E); color: #fff; }

    .menu-pick-card {
        background: #fff; border: 1px solid #f0ede9; border-radius: 16px; overflow: hidden;
        height: 100%; display: flex; flex-direction: column; transition: .2s;
    }
    .menu-pick-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(41,28,14,0.08); }
    .menu-pick-card img { width: 100%; height: 110px; object-fit: cover; }
    .menu-pick-card .no-img-mini {
        width: 100%; height: 110px; background: var(--bg-soft, #F3ECE1);
        display: flex; align-items: center; justify-content: center; color: var(--brown, #6E473B); font-size: 11px;
    }
    .menu-pick-card .body { padding: 12px; text-align: center; display: flex; flex-direction: column; flex: 1; }
    .menu-pick-card h6 { font-size: 13px; font-weight: 600; color: var(--dark, #291C0E); margin-bottom: 4px; }
    .menu-pick-card .harga-mini { font-size: 12.5px; color: var(--brown, #6E473B); font-weight: 700; margin-bottom: 4px; }
    .menu-pick-card .stok-mini { font-size: 10.5px; color: #9a8c7c; margin-bottom: 10px; }
    .menu-pick-card .btn-tambah {
        margin-top: auto; background: var(--dark, #291C0E); color: #fff; border: none;
        border-radius: 10px; padding: 8px; font-size: 12px; font-weight: 600; cursor: pointer; transition: .2s; width: 100%;
    }
    .menu-pick-card .btn-tambah:hover { background: var(--brown, #6E473B); }
    .menu-pick-card .btn-tambah:disabled { background: #ddd; cursor: not-allowed; }

    .keranjang-card { border-radius: 16px; overflow: hidden; box-shadow: 0 4px 14px rgba(41,28,14,0.06); border: none; }
    .keranjang-card .card-header {
        background: var(--dark, #291C0E); color: #fff; border: none; padding: 16px 20px;
        border-top-left-radius: 16px !important; border-top-right-radius: 16px !important;
    }
    .keranjang-card .card-header h5 { margin: 0; font-size: 14.5px; font-weight: 700; }
    .keranjang-card table {
        font-size: 12.5px; margin-bottom: 0;
        border-collapse: separate; border-spacing: 0;
        border-radius: 14px; overflow: hidden; border: 1px solid #f0ede9;
    }
    .keranjang-card thead th {
        background: var(--bg-soft, #F3ECE1); font-size: 10.5px; text-transform: uppercase;
        letter-spacing: .4px; color: var(--dark, #291C0E); border: none; font-weight: 700;
    }
    .keranjang-card thead th:first-child { border-top-left-radius: 12px; }
    .keranjang-card thead th:last-child { border-top-right-radius: 12px; }
    .keranjang-card td { vertical-align: middle; border-color: #f3ece1; }
    .keranjang-card .jumlah-cell {
        display: flex; align-items: center; gap: 4px; flex-wrap: nowrap;
    }
    .keranjang-card .btn-kurang, .keranjang-card .btn-tambah-qty {
        background: transparent; border: none; color: var(--brown, #6E473B);
        font-weight: 700; font-size: 15px; padding: 0 3px; line-height: 1; cursor: pointer; flex-shrink: 0;
    }
    .keranjang-card .btn-kurang:hover, .keranjang-card .btn-tambah-qty:hover { color: var(--dark, #291C0E); }
    .keranjang-card .qty-input {
        width: 38px; text-align: center; border: 1px solid #eee; border-radius: 6px;
        padding: 2px 0; font-size: 12.5px; font-weight: 700; flex-shrink: 0;
        -moz-appearance: textfield;
    }
    .keranjang-card .qty-input::-webkit-outer-spin-button,
    .keranjang-card .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none; margin: 0;
    }
    .keranjang-card .btn-hapus { border: none; background: transparent; color: #E53935; }
    .keranjang-card .card-footer { background: #fff; border-top: 1px solid #f0ede9; padding: 20px; }

    #voucher-info { display: none !important; }
    #voucher-info.show { display: flex !important; }
    .voucher-input-group .form-control { border-radius: 10px 0 0 10px; }
    .voucher-input-group .btn { border-radius: 0 10px 10px 0; background: var(--bg-soft, #F3ECE1); border: 1.5px solid #eee; border-left: none; color: var(--brown, #6E473B); font-weight: 600; font-size: 12.5px; }

    .metode-pilih { display: flex; gap: 10px; margin: 10px 0 16px; }
    .metode-opt { flex: 1; position: relative; }
    .metode-opt input.metode-radio { position: absolute; opacity: 0; width: 100%; height: 100%; margin: 0; cursor: pointer; }
    .metode-opt label {
        display: block; text-align: center; padding: 12px 8px; border: 1.5px solid #eee;
        border-radius: 12px; font-size: 13px; font-weight: 600; color: #6b5d4f; cursor: pointer; transition: .2s; margin: 0;
    }
    .metode-opt input.metode-radio:checked + label {
        border-color: var(--dark, #291C0E); background: var(--dark, #291C0E); color: #fff;
    }

    #btn-simpan {
        background: var(--dark, #291C0E); border: none; border-radius: 12px;
        padding: 14px; font-weight: 700; font-size: 13.5px; text-transform: uppercase; letter-spacing: .5px;
    }
    #btn-simpan:not(:disabled):hover { background: var(--brown, #6E473B); }

    .opsi-pill-input { display: none; }
    .opsi-pill-label {
        display: inline-block; padding: 9px 18px; border-radius: 100px; border: 1.5px solid #eee;
        background: #fff; font-size: 12.5px; margin-right: 8px; margin-bottom: 8px; cursor: pointer; font-weight: 500; color: var(--dark, #291C0E); transition: .2s;
    }
    .opsi-pill-input:checked + .opsi-pill-label {
        background: var(--dark, #291C0E); border-color: var(--dark, #291C0E); color: #fff;
    }

    #modalCustom .modal-content { border-radius: 18px; border: none; }
    #modalCustom .modal-header { border-bottom: 1px solid #f0ede9; }
    #modalCustom .modal-footer { border-top: 1px solid #f0ede9; }
    #modalCustom .modal-footer .btn-primary { background: var(--dark, #291C0E); border: none; border-radius: 10px; }
    #modalCustom .modal-footer .btn-secondary { border-radius: 10px; }
</style>

<div class="pesanan-baru-page">
<form id="form-pesanan" action="{{ route('kasir.pesanan.store.dinein') }}" method="POST">
    @csrf
    <div class="row">
        {{-- KIRI: Pilih Meja + Menu --}}
        <div class="col-md-8">

            <div class="info-card">
                <div class="form-group">
                    <label>Pilih Meja</label>
                    <select name="meja_id" id="meja_id" class="form-control" required>
                        <option value="">-- Pilih Meja --</option>
                        @foreach($meja as $item)
                            <option value="{{ $item->id }}">Meja {{ $item->nomor_meja }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-0">
                    <label>Nama Customer</label>
                    <input type="text" name="nama_customer" id="nama_customer" class="form-control" placeholder="Masukkan nama (opsional)">
                </div>
            </div>

            <div class="menu-card-wrap">
                <div class="kategori-scroll-row">
                    <button type="button" class="kategori-btn active" data-kategori="all">
                        Semua
                    </button>
                    @foreach($kategori as $kat)
                        <button type="button" class="kategori-btn" data-kategori="{{ $kat->id }}">
                            {{ $kat->nama_kategori }}
                        </button>
                    @endforeach
                </div>

                <div class="row" id="menu-list">
                    @foreach($kategori as $kat)
                        @foreach($kat->menu as $m)
                            <div class="col-md-4 mb-3 menu-item" data-kategori="{{ $kat->id }}">
                                <div class="menu-pick-card">
                                    @if($m->gambar)
                                        <img src="{{ asset('uploads/menu/'.$m->gambar) }}">
                                    @else
                                        <div class="no-img-mini">No Image</div>
                                    @endif
                                    <div class="body">
                                        <h6>{{ $m->nama_menu }}</h6>
                                        <div class="harga-mini">Rp {{ number_format($m->harga, 0, ',', '.') }}</div>
                                        <div class="stok-mini">Stok: {{ $m->stok }}</div>
                                        <button type="button"
                                            class="btn-tambah"
                                            data-id="{{ $m->id }}"
                                            data-nama="{{ $m->nama_menu }}"
                                            data-harga="{{ $m->harga }}"
                                            data-stok="{{ $m->stok }}"
                                            data-kustom="{{ $kat->perlu_kustomisasi ? '1' : '0' }}"
                                            {{ $m->stok <= 0 ? 'disabled' : '' }}>
                                            {{ $m->stok <= 0 ? 'Stok Habis' : ' Tambah' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>

        </div>

        {{-- KANAN: Keranjang + Pembayaran --}}
        <div class="col-md-4">
            <div class="card keranjang-card">
                <div class="card-header">
                    <h5><i class="fas fa-shopping-cart"></i> Keranjang</h5>
                </div>
                <div class="card-body" id="keranjang-body">
                    <p class="text-muted text-center" id="keranjang-kosong">Belum ada item dipilih.</p>
                    <table class="table table-sm" id="tabel-keranjang" style="display:none;">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th width="110">Jumlah</th>
                                <th width="90">Subtotal</th>
                                <th width="30"></th>
                            </tr>
                        </thead>
                        <tbody id="keranjang-items"></tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total Belanja</strong>
                        <strong id="total-harga">Rp 0</strong>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold" style="font-size:12px; text-transform:uppercase; letter-spacing:.4px; color:var(--dark);">Kode Voucher</label>
                        <div class="input-group voucher-input-group">
                            <input type="text" id="kode_voucher" class="form-control" placeholder="Masukkan kode voucher">
                            <div class="input-group-append">
                                <button type="button" class="btn" id="btn-terapkan-voucher">Terapkan</button>
                            </div>
                        </div>
                        <small id="voucher-message" class="form-text"></small>
                    </div>

                    <div id="voucher-info" class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-success small">Diskon (<span id="voucher-kode-label"></span>)</span>
                        <span>
                            <span class="text-success small">- <span id="voucher-diskon">Rp 0</span></span>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0 ml-2" id="btn-batal-voucher">Batal</button>
                        </span>
                    </div>

                    <input type="hidden" name="voucher_id" id="voucher_id_input">

                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total Bayar</strong>
                        <strong id="total-akhir">Rp 0</strong>
                    </div>

                    <hr>

                    <label class="font-weight-bold" style="font-size:12px; text-transform:uppercase; letter-spacing:.4px; color:var(--dark);">Metode Pembayaran</label>
                    <div class="metode-pilih">
                        <div class="metode-opt">
                            <input class="metode-radio" type="radio" name="metode" id="metode-tunai" value="tunai">
                            <label for="metode-tunai">Tunai</label>
                        </div>
                        <div class="metode-opt">
                            <input class="metode-radio" type="radio" name="metode" id="metode-qris" value="qris">
                            <label for="metode-qris">QRIS</label>
                        </div>
                    </div>

                    <div id="area-tunai" style="display:none;">
                        <div class="form-group">
                            <label>Uang Dibayar</label>
                                <input type="text" id="uang_dibayar" name="uang_dibayar" class="form-control" inputmode="numeric">
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong>Kembalian</strong>
                            <strong id="kembalian">Rp 0</strong>
                        </div>
                    </div>

                    <div id="area-qris" style="display:none;" class="text-center">
                        <div id="qris-loading" style="display:none;">
                            <p class="text-muted">Membuat QR code...</p>
                        </div>
                        <div id="qris-qr-wrapper" style="display:none;">
                            <img id="qris-qr-image" src="" alt="QR QRIS" style="max-width:200px;">
                            <p class="mt-2 mb-0">
                                Status: <span id="qris-status" class="badge badge-warning">Menunggu Pembayaran</span>
                            </p>
                        </div>
                        <input type="hidden" name="qris_order_id" id="qris_order_id">
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-success btn-block" id="btn-simpan" disabled>
                        Simpan Pesanan
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>

{{-- MODAL PILIH GULA & ES --}}
<div class="modal fade" id="modalCustom" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCustomTitle">Custom Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <label class="font-weight-bold" style="font-size:12px; text-transform:uppercase; letter-spacing:.4px; color:var(--brown);">Level Gula</label>
                <div class="form-group">
                    <input class="opsi-pill-input custom-gula" type="radio" name="modal_gula" id="gula-normal" value="Normal" checked>
                    <label class="opsi-pill-label" for="gula-normal">Normal</label>

                    <input class="opsi-pill-input custom-gula" type="radio" name="modal_gula" id="gula-kurang" value="Kurang Manis">
                    <label class="opsi-pill-label" for="gula-kurang">Kurang Manis</label>

                    <input class="opsi-pill-input custom-gula" type="radio" name="modal_gula" id="gula-tanpa" value="Tanpa Gula">
                    <label class="opsi-pill-label" for="gula-tanpa">Tanpa Gula</label>
                </div>

                <label class="font-weight-bold" style="font-size:12px; text-transform:uppercase; letter-spacing:.4px; color:var(--brown);">Level Es</label>
                <div class="form-group mb-0">
                    <input class="opsi-pill-input custom-es" type="radio" name="modal_es" id="es-normal" value="Normal" checked>
                    <label class="opsi-pill-label" for="es-normal">Normal</label>

                    <input class="opsi-pill-input custom-es" type="radio" name="modal_es" id="es-sedikit" value="Sedikit Es">
                    <label class="opsi-pill-label" for="es-sedikit">Sedikit Es</label>

                    <input class="opsi-pill-input custom-es" type="radio" name="modal_es" id="es-tanpa" value="Tanpa Es">
                    <label class="opsi-pill-label" for="es-tanpa">Tanpa Es</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-modal-tambah">Tambahkan ke Keranjang</button>
            </div>
        </div>
    </div>
</div>

{{-- INFO/PERINGATAN MODAL — pengganti tampilkanPeringatan() bawaan browser --}}
<div class="rr-confirm-overlay" id="rrInfoModal">
    <div class="rr-confirm-box">
        <div class="rr-confirm-icon" style="background: rgba(224,165,39,0.12); color: #E0A527;">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <h4 id="rrInfoTitle">Perhatian</h4>
        <p id="rrInfoText"></p>
        <div class="rr-confirm-actions">
            <button type="button" class="rr-confirm-ok" style="width:100%;" onclick="tutupInfoModal()">OK</button>
        </div>
    </div>
</div>
</div>

@endsection

@section('js')
<script>
const QTY_MAX = 100;

function tampilkanPeringatan(pesan, judul) {
    document.getElementById('rrInfoTitle').textContent = judul || 'Perhatian';
    document.getElementById('rrInfoText').textContent = pesan;
    document.getElementById('rrInfoModal').classList.add('show');
}
function tutupInfoModal() {
    document.getElementById('rrInfoModal').classList.remove('show');
}
document.getElementById('rrInfoModal').addEventListener('click', function (e) {
    if (e.target === this) tutupInfoModal();
});

let keranjang = [];
let qrisPollInterval = null;
let qrisLunas = false;
let itemDipilih = null;
let voucherAktif = null;

function totalQtyUntukMenu(menuId) {
    return keranjang.filter(item => item.id === menuId).reduce((sum, item) => sum + item.qty, 0);
}

function batasMaxUntukMenu(stok) {
    return Math.min(QTY_MAX, stok);
}

function pesanBatas(nama, stok) {
    return stok < QTY_MAX
        ? `Stok "${nama}" tersisa ${stok}, sudah mencapai batas.`
        : `Jumlah "${nama}" sudah mencapai batas maksimal ${QTY_MAX}.`;
}

// ================= FILTER KATEGORI =================
document.querySelectorAll('.kategori-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.kategori-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const kategoriId = this.dataset.kategori;
        document.querySelectorAll('.menu-item').forEach(item => {
            item.style.display = (kategoriId === 'all' || item.dataset.kategori === kategoriId) ? '' : 'none';
        });
    });
});

// ================= BUKA MODAL PAS KLIK "+ TAMBAH" =================
document.querySelectorAll('.btn-tambah').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const nama = this.dataset.nama;
        const harga = parseInt(this.dataset.harga);
        const stok = parseInt(this.dataset.stok);
        const butuhKustom = this.dataset.kustom === '1';

        const batas = batasMaxUntukMenu(stok);
        if (totalQtyUntukMenu(id) >= batas) {
            tampilkanPeringatan(pesanBatas(nama, stok));
            return;
        }

        if (!butuhKustom) {
            const existing = keranjang.find(item =>
                item.id === id && !item.level_gula && !item.level_es
            );

            if (existing) {
                existing.qty++;
            } else {
                keranjang.push({ id, nama, harga, qty: 1, level_gula: null, level_es: null, stok });
            }

            renderKeranjang();
            return;
        }

        itemDipilih = { id, nama, harga, stok };

        document.getElementById('modalCustomTitle').textContent = 'Custom - ' + itemDipilih.nama;
        document.getElementById('gula-normal').checked = true;
        document.getElementById('es-normal').checked = true;

        $('#modalCustom').modal('show');
    });
});

// ================= TOMBOL "TAMBAHKAN KE KERANJANG" DI MODAL =================
document.getElementById('btn-modal-tambah').addEventListener('click', function () {
    const levelGula = document.querySelector('.custom-gula:checked').value;
    const levelEs = document.querySelector('.custom-es:checked').value;

    const batas = batasMaxUntukMenu(itemDipilih.stok);
    if (totalQtyUntukMenu(itemDipilih.id) >= batas) {
        tampilkanPeringatan(pesanBatas(itemDipilih.nama, itemDipilih.stok));
        $('#modalCustom').modal('hide');
        return;
    }

    const existing = keranjang.find(item =>
        item.id === itemDipilih.id && item.level_gula === levelGula && item.level_es === levelEs
    );

    if (existing) {
        existing.qty++;
    } else {
        keranjang.push({
            id: itemDipilih.id,
            nama: itemDipilih.nama,
            harga: itemDipilih.harga,
            qty: 1,
            level_gula: levelGula,
            level_es: levelEs,
            stok: itemDipilih.stok,
        });
    }

    renderKeranjang();
    $('#modalCustom').modal('hide');
});

function getTotal() {
    return keranjang.reduce((sum, item) => sum + (item.harga * item.qty), 0);
}

function renderKeranjang() {
    const tbody = document.getElementById('keranjang-items');
    const tabel = document.getElementById('tabel-keranjang');
    const kosong = document.getElementById('keranjang-kosong');

    if (keranjang.length === 0) {
        tabel.style.display = 'none';
        kosong.style.display = '';
        document.getElementById('total-harga').textContent = 'Rp 0';
        batalkanVoucher();
        return;
    }

    tabel.style.display = '';
    kosong.style.display = 'none';
    tbody.innerHTML = '';

    keranjang.forEach((item, index) => {
        const subtotal = item.harga * item.qty;
        const batasItem = batasMaxUntukMenu(item.stok);
        tbody.innerHTML += `
            <tr>
                <td>
                    ${item.nama}
                    ${item.level_gula ? `<br><small class="text-muted">${item.level_gula}, ${item.level_es}</small>` : ''}
                </td>
                <td>
                    <div class="jumlah-cell">
                        <button type="button" class="btn-kurang" data-index="${index}">−</button>
                        <input type="number" class="qty-input" data-index="${index}" value="${item.qty}" min="1" max="${batasItem}">
                        <button type="button" class="btn-tambah-qty" data-index="${index}">+</button>
                    </div>
                </td>
                <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td>
                    <button type="button" class="btn btn-xs btn-outline-danger btn-hapus" data-index="${index}">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    document.getElementById('total-harga').textContent = 'Rp ' + getTotal().toLocaleString('id-ID');

    document.querySelectorAll('.btn-tambah-qty').forEach(btn => {
        btn.addEventListener('click', function () {
            const item = keranjang[this.dataset.index];
            const batas = batasMaxUntukMenu(item.stok);
            if (totalQtyUntukMenu(item.id) >= batas) {
                tampilkanPeringatan(pesanBatas(item.nama, item.stok));
                return;
            }
            item.qty++;
            renderKeranjang();
        });
    });
    document.querySelectorAll('.btn-kurang').forEach(btn => {
        btn.addEventListener('click', function () {
            const i = this.dataset.index;
            keranjang[i].qty--;
            if (keranjang[i].qty <= 0) keranjang.splice(i, 1);
            renderKeranjang();
        });
    });
    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function () {
            keranjang.splice(this.dataset.index, 1);
            renderKeranjang();
        });
    });
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('input', function () {
            const idx = this.dataset.index;
            const item = keranjang[idx];
            let val = parseInt(this.value) || 0;

            const totalMenuLain = totalQtyUntukMenu(item.id) - item.qty;
            const maksUntukItemIni = Math.max(1, batasMaxUntukMenu(item.stok) - totalMenuLain);

            if (val > maksUntukItemIni) {
                val = maksUntukItemIni;
                this.value = val;
                if (this.dataset.sudahAlert !== '1') {
                    tampilkanPeringatan(`Menu "${item.nama}" sisa ${item.stok}, jumlah gak bisa melebihi itu.`);
                    this.dataset.sudahAlert = '1';
                }
            } else {
                this.dataset.sudahAlert = '';
            }

            if (val > 0) {
                item.qty = val;
                const row = this.closest('tr');
                row.children[2].textContent = 'Rp ' + (item.harga * item.qty).toLocaleString('id-ID');
                document.getElementById('total-harga').textContent = 'Rp ' + getTotal().toLocaleString('id-ID');
                if (voucherAktif) {
                    terapkanVoucher(voucherAktif.kode, false);
                } else {
                    renderTotalAkhir();
                }
            }
        });

        input.addEventListener('blur', function () {
            const idx = this.dataset.index;
            const item = keranjang[idx];
            if (!this.value || parseInt(this.value) <= 0) {
                item.qty = 1;
                renderKeranjang();
            }
        });
    });

    if (voucherAktif) {
        terapkanVoucher(voucherAktif.kode, false);
    } else {
        renderTotalAkhir();
    }
}

// ================= VOUCHER =================
function getTotalAkhir() {
    const total = getTotal();
    if (voucherAktif) {
        return Math.max(0, total - voucherAktif.diskon);
    }
    return total;
}

function renderTotalAkhir() {
    document.getElementById('total-akhir').textContent = 'Rp ' + getTotalAkhir().toLocaleString('id-ID');
    hitungKembalian();
    updateTombolSimpan();
}

function terapkanVoucher(kode, showAlert = true) {
    const total = getTotal();
    if (total <= 0) {
        if (showAlert) tampilkanPeringatan('Keranjang masih kosong, pilih menu dulu.');
        return;
    }

    fetch("{{ route('kasir.pesanan.voucher.cek') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
        },
        body: JSON.stringify({ kode: kode, total: total })
    })
    .then(res => res.json())
    .then(data => {
        const msg = document.getElementById('voucher-message');

        if (!data.success) {
            msg.textContent = data.message;
            msg.className = 'form-text text-danger';
            voucherAktif = null;
            document.getElementById('voucher_id_input').value = '';
            document.getElementById('voucher-info').classList.remove('show');
            renderTotalAkhir();
            return;
        }

        voucherAktif = { id: data.voucher_id, kode: data.kode, diskon: data.diskon };
        document.getElementById('voucher_id_input').value = data.voucher_id;

        msg.textContent = '';
        document.getElementById('voucher-info').classList.add('show');
        document.getElementById('voucher-kode-label').textContent = data.kode;
        document.getElementById('voucher-diskon').textContent = 'Rp ' + data.diskon.toLocaleString('id-ID');

        renderTotalAkhir();
    })
    .catch(() => {
        tampilkanPeringatan('Terjadi kesalahan saat mengecek voucher.');
    });
}

function batalkanVoucher() {
    voucherAktif = null;
    document.getElementById('voucher_id_input').value = '';
    document.getElementById('voucher-info').classList.remove('show');
    document.getElementById('kode_voucher').value = '';
    document.getElementById('voucher-message').textContent = '';
    renderTotalAkhir();
}

document.getElementById('btn-terapkan-voucher').addEventListener('click', function () {
    const kode = document.getElementById('kode_voucher').value.trim();
    if (!kode) {
        tampilkanPeringatan('Masukkan kode voucher terlebih dahulu.');
        return;
    }
    terapkanVoucher(kode);
});

document.getElementById('btn-batal-voucher').addEventListener('click', batalkanVoucher);

// ================= PILIH METODE =================
document.querySelectorAll('.metode-radio').forEach(radio => {
    radio.addEventListener('change', function () {
        document.getElementById('area-tunai').style.display = 'none';
        document.getElementById('area-qris').style.display = 'none';

        if (qrisPollInterval) {
            clearInterval(qrisPollInterval);
            qrisPollInterval = null;
        }
        qrisLunas = false;

        if (this.value === 'tunai') {
            document.getElementById('area-tunai').style.display = '';
        }

        if (this.value === 'qris') {
            document.getElementById('area-qris').style.display = '';
            mulaiGenerateQris();
        }

        updateTombolSimpan();
    });
});

// ================= TUNAI =================
document.getElementById('uang_dibayar').addEventListener('input', function () {
    let angka = this.value.replace(/\D/g, '');
    this.value = angka ? new Intl.NumberFormat('id-ID').format(angka) : '';
    hitungKembalian();
});

function hitungKembalian() {
    const uangMentah = document.getElementById('uang_dibayar').value.replace(/\D/g, '');
    const uang = parseInt(uangMentah) || 0;
    const total = getTotalAkhir();
    const kembalian = uang - total;

    document.getElementById('kembalian').textContent =
        'Rp ' + (kembalian > 0 ? kembalian : 0).toLocaleString('id-ID');

    updateTombolSimpan();
}

// ================= QRIS =================
function mulaiGenerateQris() {
    const total = getTotalAkhir();
    if (total <= 0) {
        tampilkanPeringatan('Keranjang masih kosong, pilih menu dulu.');
        return;
    }

    document.getElementById('qris-loading').style.display = '';
    document.getElementById('qris-qr-wrapper').style.display = 'none';

    fetch("{{ route('kasir.pesanan.qris.generate') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
        },
        body: JSON.stringify({ total: total })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('qris-loading').style.display = 'none';

        if (!data.success) {
            tampilkanPeringatan('Gagal membuat QR: ' + data.message);
            return;
        }

        document.getElementById('qris-qr-image').src = data.qr_url;
        document.getElementById('qris_order_id').value = data.order_id;
        document.getElementById('qris-qr-wrapper').style.display = '';
        document.getElementById('qris-status').textContent = 'Menunggu Pembayaran';
        document.getElementById('qris-status').className = 'badge badge-warning';

        qrisPollInterval = setInterval(() => cekStatusQris(data.order_id), 3000);
    })
    .catch(() => {
        document.getElementById('qris-loading').style.display = 'none';
        tampilkanPeringatan('Terjadi kesalahan saat menghubungi server pembayaran.');
    });
}

function cekStatusQris(orderId) {
    fetch(`/kasir/pesanan/qris/status/${orderId}`)
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;

            if (data.transaction_status === 'settlement' || data.transaction_status === 'capture') {
                clearInterval(qrisPollInterval);
                qrisPollInterval = null;
                qrisLunas = true;

                document.getElementById('qris-status').textContent = 'Lunas';
                document.getElementById('qris-status').className = 'badge badge-success';

                updateTombolSimpan();
            }
        });
}

// ================= TOMBOL SIMPAN =================
function updateTombolSimpan() {
    const btn = document.getElementById('btn-simpan');
    const metode = document.querySelector('.metode-radio:checked')?.value;
    const total = getTotalAkhir();

    if (keranjang.length === 0 || !metode) {
        btn.disabled = true;
        return;
    }

    if (metode === 'tunai') {
        const uangMentah = document.getElementById('uang_dibayar').value.replace(/\D/g, '');
        const uang = parseInt(uangMentah) || 0;
        btn.disabled = uang < total;
        return;
    }

    if (metode === 'qris') {
        btn.disabled = !qrisLunas;
        return;
    }

    btn.disabled = true;
}

// ================= SUBMIT =================
document.getElementById('form-pesanan').addEventListener('submit', function (e) {
    if (keranjang.length === 0) {
        e.preventDefault();
        tampilkanPeringatan('Keranjang masih kosong, pilih menu dulu.');
        return;
    }

    keranjang.forEach((item, index) => {
        const fields = {
            [`items[${index}][menu_id]`]: item.id,
            [`items[${index}][qty]`]: item.qty,
            [`items[${index}][level_gula]`]: item.level_gula,
            [`items[${index}][level_es]`]: item.level_es,
        };

        for (const name in fields) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = fields[name];
            this.appendChild(input);
        }
    });
});
</script>
@endsection