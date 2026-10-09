<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Barista\MenuController as BaristaMenuController;
use App\Http\Controllers\Barista\PesananController as BaristaPesananController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\Kasir\PesananController as KasirPesananController;
use App\Http\Controllers\Kasir\ShiftController;
use App\Http\Controllers\KategoriMenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResiController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\VoucherController;
use App\Models\Voucher;
use App\Models\Rating;
use App\Models\KategoriMenu;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $kategori = KategoriMenu::with(['menu' => function ($q) {
        $q->where('status', 'tersedia')
          ->withAvg('ratings', 'bintang')
          ->withCount('ratings')
          ->withSum('detailPesanan as total_terjual', 'qty');
    }])->get();

    $menuPreview = Menu::where('status', 'tersedia')
        ->withAvg('ratings', 'bintang')
        ->withCount('ratings')
        ->withSum('detailPesanan as total_terjual', 'qty')
        ->orderByDesc('total_terjual')
        ->take(3)
        ->get();

    $topMenuId = (optional($menuPreview->first())->total_terjual > 0)
        ? $menuPreview->first()->id
        : null;

    $totalMeja = Meja::count();
    $mejaTerisi = Meja::where('status', 'dipesan')->count();
    $mejaKosong = max(0, $totalMeja - $mejaTerisi);
    $persenTerisi = $totalMeja > 0 ? ($mejaTerisi / $totalMeja) * 100 : 0;

    if ($persenTerisi >= 90) {
        $kepadatan = ['label' => 'Penuh', 'warna' => 'red'];
    } elseif ($persenTerisi >= 50) {
        $kepadatan = ['label' => 'Hampir Penuh', 'warna' => 'yellow'];
    } else {
        $kepadatan = ['label' => 'Masih Banyak Meja', 'warna' => 'green'];
    }

    $vouchers = Voucher::where('status', 'aktif')
        ->whereDate('tanggal_mulai', '<=', now())
        ->whereDate('tanggal_expired', '>=', now())
        ->latest()
        ->get()
        ->filter(fn ($v) => $v->batas_pemakaian == 0 || $v->jumlah_terpakai < $v->batas_pemakaian)
        ->take(3);

    $reviewsPreview = Rating::with(['menu', 'detailPesanan.pesanan'])
        ->whereNotNull('komentar')
        ->where('komentar', '!=', '')
        ->where('bintang', '>=', 4)
        ->latest()
        ->take(3)
        ->get();

    $totalRating = Rating::count();
    $avgRating = $totalRating > 0 ? Rating::avg('bintang') : 0;

    return view('landing.index', compact(
        'kategori', 'kepadatan', 'vouchers', 'reviewsPreview', 'totalRating', 'avgRating',
        'topMenuId', 'menuPreview', 'mejaKosong','mejaTerisi', 'totalMeja'
    ));
})->name('landing');

Route::get('/ulasan', function (\Illuminate\Http\Request $request) {
    $breakdown = Rating::selectRaw('bintang, count(*) as total')
        ->groupBy('bintang')
        ->pluck('total', 'bintang');

    $totalRating = (int) $breakdown->sum();
    $avgRating = $totalRating > 0 ? Rating::avg('bintang') : 0;

    $filterBintang = $request->query('bintang');

    $ulasan = Rating::with(['menu', 'detailPesanan.pesanan'])
        ->when($filterBintang, fn ($q) => $q->where('bintang', $filterBintang))
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('landing.ulasan', compact('breakdown', 'totalRating', 'avgRating', 'ulasan', 'filterBintang'));
})->name('ulasan.index');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('store.register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('store.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ================== ADMIN ==================
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(['auth', 'role:admin'])
        ->group(function () {

            Route::get('/', function () {
                $totalMenu = Menu::count();
                $totalMeja = Meja::count();

                $totalPesanan = Pesanan::whereDate('created_at', today())->count();
                $totalPendapatan = Pesanan::where('status_pembayaran', 'berhasil')
                    ->whereDate('created_at', today())
                    ->sum('total');

                $pesananTerbaru = Pesanan::with('meja')
                    ->whereDate('created_at', today())
                    ->latest()
                    ->take(5)
                    ->get();

                $statusMenunggu = Pesanan::where('status_pembayaran', 'menunggu')
                    ->whereDate('created_at', today())->count();
                $statusBerhasil = Pesanan::where('status_pembayaran', 'berhasil')
                    ->whereDate('created_at', today())->count();
                $statusDibatalkan = Pesanan::where('status_pembayaran', 'dibatalkan')
                    ->whereDate('created_at', today())->count();

                return view('dashboard.admin.index', compact(
                    'totalMenu', 'totalMeja', 'totalPesanan', 'totalPendapatan',
                    'pesananTerbaru', 'statusMenunggu', 'statusBerhasil', 'statusDibatalkan'
                ));
            })->name('dashboard');
        
        Route::get('/profil', [ProfileController::class, 'index'])->name('profil');

        Route::prefix('kategori-menu')->name('kategori-menu.')->group(function () {
            Route::get('/', [KategoriMenuController::class, 'index'])->name('index');
            Route::get('/create', [KategoriMenuController::class, 'create'])->name('create');
            Route::post('/create', [KategoriMenuController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [KategoriMenuController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [KategoriMenuController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [KategoriMenuController::class, 'destroy'])->name('delete');
        });

        Route::prefix('menu')->name('menu.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::get('/create', [MenuController::class, 'create'])->name('create');
            Route::post('/create', [MenuController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [MenuController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [MenuController::class, 'destroy'])->name('delete');
        });

        Route::prefix('meja')->name('meja.')->group(function () {
            Route::get('/', [MejaController::class, 'index'])->name('index');
            Route::get('/create', [MejaController::class, 'create'])->name('create');
            Route::post('/create', [MejaController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MejaController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [MejaController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [MejaController::class, 'destroy'])->name('delete');
            Route::get('/{id}/qrcode', [MejaController::class, 'qrcode'])->name('qrcode');
            Route::get('/{id}/download', [MejaController::class, 'download'])->name('download');
            Route::get('/{id}/print', [MejaController::class, 'print'])->name('print');
        });

        Route::prefix('pesanan')->name('pesanan.')->group(function () {
            Route::get('/', [PesananController::class, 'index'])->name('index');
            Route::get('/{id}', [PesananController::class, 'show'])->name('show');
            Route::put('/{id}', [PesananController::class, 'update'])->name('update');
            Route::delete('/{id}', [PesananController::class, 'destroy'])->name('delete');
        });

        Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
            Route::get('/', [PembayaranController::class, 'index'])->name('index');
            Route::get('/create', [PembayaranController::class, 'create'])->name('create');
            Route::post('/create', [PembayaranController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [PembayaranController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [PembayaranController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [PembayaranController::class, 'destroy'])->name('delete');
        });

        Route::prefix('pegawai')->name('pegawai.')->group(function () {
            Route::get('/', [PegawaiController::class, 'index'])->name('index');
            Route::get('/create', [PegawaiController::class, 'create'])->name('create');
            Route::post('/create', [PegawaiController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [PegawaiController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [PegawaiController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [PegawaiController::class, 'destroy'])->name('delete');
            Route::get('/show/{id}', [PegawaiController::class, 'show'])->name('show');
        });

        Route::prefix('resi')->name('resi.')->group(function () {
            Route::get('/', [ResiController::class, 'index'])->name('index');
            Route::get('/create', [ResiController::class, 'create'])->name('create');
            Route::post('/create', [ResiController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ResiController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [ResiController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [ResiController::class, 'destroy'])->name('delete');
            Route::get('/qr/{id}', [ResiController::class, 'showQr'])->name('qr');
        });

        Route::prefix('shift')->name('shift.')->group(function () {
            Route::get('/', [PegawaiController::class, 'shiftIndex'])->name('index');
            Route::get('/{id}', [PegawaiController::class, 'shiftShow'])->name('show');
        });

        Route::get('/laporan', [PesananController::class, 'laporan'])->name('laporan');
        Route::get('/laporan/pdf', [PesananController::class, 'laporanPdf'])->name('laporan.pdf');

        Route::prefix('voucher')->name('voucher.')->group(function () {
        Route::get('/', [VoucherController::class, 'index'])->name('index');
        Route::get('/create', [VoucherController::class, 'create'])->name('create');
        Route::post('/create', [VoucherController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [VoucherController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [VoucherController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [VoucherController::class, 'destroy'])->name('delete');
});
    });


// ================== KASIR ==================
Route::prefix('kasir')
    ->name('kasir.')
    ->middleware(['auth', 'role:kasir'])
    ->group(function () {

        // Route Shift - TIDAK pakai middleware shift.aktif (biar nggak infinite redirect)
        Route::prefix('shift')->name('shift.')->group(function () {
            Route::get('/buka', [ShiftController::class, 'bukaForm'])->name('buka');
            Route::post('/buka', [ShiftController::class, 'buka'])->name('buka.proses');
            Route::get('/tutup', [ShiftController::class, 'tutupForm'])->name('tutup');
            Route::post('/tutup', [ShiftController::class, 'tutup'])->name('tutup.proses');
        });

        Route::get('/profil', [ProfileController::class, 'index'])->name('profil');

        // Semua route lain WAJIB ada shift aktif
        Route::middleware('shift.aktif')->group(function () {

            Route::get('/dashboard', [KasirPesananController::class, 'dashboard'])->name('dashboard');

            Route::prefix('pesanan')->name('pesanan.')->group(function () {
                Route::get('/', [KasirPesananController::class, 'index'])->name('index');
                Route::get('/baru', [KasirPesananController::class, 'create'])->name('create');
                Route::get('/baru/dine-in', [KasirPesananController::class, 'createDineIn'])->name('create.dinein');
                Route::post('/baru/dine-in', [KasirPesananController::class, 'storeDineIn'])->name('store.dinein');
                Route::get('/baru/take-away', [KasirPesananController::class, 'createTakeAway'])->name('create.takeaway');
                Route::post('/baru/take-away', [KasirPesananController::class, 'storeTakeAway'])->name('store.takeaway');
                Route::get('/{id}/bayar', [KasirPesananController::class, 'bayar'])->name('bayar');
                Route::post('/{id}/bayar', [KasirPesananController::class, 'prosesBayar'])->name('bayar.proses');
                Route::get('/{id}', [KasirPesananController::class, 'show'])->name('show');
                Route::delete('/{id}', [KasirPesananController::class, 'destroy'])->name('destroy');
                Route::post('/qris/generate', [KasirPesananController::class, 'generateQris'])->name('qris.generate');
                Route::post('/voucher/cek', [KasirPesananController::class, 'cekVoucher'])->name('voucher.cek');
                Route::get('/qris/status/{orderId}', [KasirPesananController::class, 'statusQris'])->name('qris.status');
                Route::put('/{id}/kosongkan-meja', [KasirPesananController::class, 'kosongkanMeja'])->name('kosongkan-meja');
                Route::get('/{id}/resi', [KasirPesananController::class, 'resi'])->name('resi');
            });

        });

    });


// ================== BARISTA ==================
Route::prefix('barista')
    ->name('barista.')
    ->middleware(['auth', 'role:barista'])
    ->group(function () {

       Route::get('/dashboard', function () {
        $jumlahBaru = \App\Models\Pesanan::where('status_pembayaran', 'berhasil')
            ->where('status_pesanan', 'baru')->count();

        $jumlahDiproses = \App\Models\Pesanan::where('status_pembayaran', 'berhasil')
            ->where('status_pesanan', 'sedang_dibuat')->count();

        $jumlahSiap = \App\Models\Pesanan::where('status_pembayaran', 'berhasil')
            ->whereIn('status_pesanan', ['siap_disajikan', 'siap_diambil'])->count();

        return view('dashboard.barista.index', compact('jumlahBaru', 'jumlahDiproses', 'jumlahSiap')); })->name('dashboard');

        Route::get('/profil', [ProfileController::class, 'index'])->name('profil');

        Route::prefix('pesanan')->name('pesanan.')->group(function () {
            Route::get('/', [BaristaPesananController::class, 'index'])->name('index');
            Route::put('/{id}/status', [BaristaPesananController::class, 'updateStatus'])->name('status');
            Route::get('/riwayat', [BaristaPesananController::class, 'riwayat'])->name('riwayat');
        });

        Route::prefix('menu')->name('menu.')->group(function () {
            Route::get('/', [BaristaMenuController::class, 'index'])->name('index');
            Route::put('/{id}/toggle', [BaristaMenuController::class, 'toggleStatus'])->name('toggle');
            Route::put('/{id}/update-stok', [BaristaMenuController::class, 'updateStok'])->name('update-stok');
        });

    });

Route::prefix('order')->name('order.')->group(function () {
    Route::get('/{kode_qr}', [UserOrderController::class, 'index'])->name('index');
    Route::post('/{kode_qr}/cart/sync', [UserOrderController::class, 'syncCart'])->name('cart.sync');
    Route::get('/{kode_qr}/checkout', [UserOrderController::class, 'checkoutPage'])->name('checkout.page');
    Route::post('/{kode_qr}/qris/generate', [UserOrderController::class, 'generateQris'])->name('qris.generate');
    Route::get('/qris/status/{orderId}', [UserOrderController::class, 'statusQris'])->name('qris.status');
    Route::post('/{kode_qr}/checkout', [UserOrderController::class, 'checkout'])->name('checkout');
    Route::get('/sukses/{kode}', [UserOrderController::class, 'sukses'])->name('sukses');
    Route::get('/{kode_qr}/pesanan', [UserOrderController::class, 'pesananSaya'])->name('pesanan');
    Route::get('/{kode_qr}/riwayat', [UserOrderController::class, 'riwayatSaya'])->name('riwayat');
    Route::post('/{kode_qr}/rating', [UserOrderController::class, 'submitRating'])->name('rating.store');
    Route::get('/{kode_qr}/voucher', [UserOrderController::class, 'voucherList'])->name('voucher.list');
    Route::post('/{kode_qr}/voucher/apply', [UserOrderController::class, 'applyVoucher'])->name('voucher.apply');
    Route::post('/{kode_qr}/voucher/remove', [UserOrderController::class, 'removeVoucher'])->name('voucher.remove');
});


