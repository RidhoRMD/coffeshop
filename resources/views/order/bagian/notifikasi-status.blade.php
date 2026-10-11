{{-- Notifikasi status pesanan untuk customer.
     Dipasang di halaman customer (kecuali Pesanan, yang sudah refresh sendiri).
     Wajib dikirim dari halaman: $kodeQr --}}
<div id="rr-notif-wadah"></div>

<style>
    #rr-notif-wadah {
        position: fixed;
        top: calc(env(safe-area-inset-top, 0px) + 14px);
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 28px);
        max-width: 440px;
        z-index: 1200;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    }
    .rr-notif {
        pointer-events: auto;
        display: flex;
        align-items: stretch;
        background: #291C0E;
        color: #fff;
        border-radius: 16px;
        box-shadow: 0 14px 40px rgba(26, 18, 11, 0.35);
        font-family: 'Poppins', sans-serif;
        animation: rrNotifMasuk 0.35s ease;
    }
    .rr-notif-isi {
        flex: 1;
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 8px 14px 16px;
        color: inherit;
        text-decoration: none;
    }
    .rr-notif-ikon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #E1D4C2;
        flex-shrink: 0;
    }
    .rr-notif-ikon svg {
        width: 20px;
        height: 20px;
        fill: currentColor;
    }
    .rr-notif-teks { 
        display: flex; 
        flex-direction: column; 
        min-width: 0; 
    }

    .rr-notif-teks strong { 
        font-size: 13.5px; 
        font-weight: 600; 
        line-height: 1.3; 
    }
    .rr-notif-teks small {
        font-size: 11.5px; 
        color: #BEB5A9; 
        line-height: 1.4; 
        margin-top: 2px; 
    }
    .rr-notif-tutup {
        background: none;
        border: none;
        color: #BEB5A9;
        font-size: 22px;
        line-height: 1;
        padding: 0 14px;
        cursor: pointer;
    }
    @keyframes rrNotifMasuk {
        from { opacity: 0; transform: translateY(-12px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    (function () {
        const KODE_QR = @json($kodeQr);
        const URL_STATUS = @json(route('order.status', $kodeQr));
        const URL_PESANAN = @json(route('order.pesanan', $kodeQr));
        const URL_RIWAYAT = @json(route('order.riwayat', $kodeQr));
        const INTERVAL_MS = 5000;
        const KUNCI = 'rr_status_' + KODE_QR;
        const MAKS_TAMPIL = 3;
        const LAMA_TAMPIL_MS = 10000;

        const IKON = {
            cangkir: '<svg viewBox="0 0 24 24"><path d="M4 3h13v9a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V3zm13 3h2a3 3 0 0 1 0 6h-2v-2h2a1 1 0 0 0 0-2h-2V6zM4 19h13v2H4v-2z"/></svg>',
            lonceng: '<svg viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>',
            tas: '<svg viewBox="0 0 24 24"><path d="M18 6h-2c0-2.21-1.79-4-4-4S8 3.79 8 6H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-6-2c1.1 0 2 .9 2 2h-4c0-1.1.9-2 2-2zm6 16H6V8h2v2c0 .55.45 1 1 1s1-.45 1-1V8h4v2c0 .55.45 1 1 1s1-.45 1-1V8h2v12z"/></svg>',
            bintang: '<svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>'
        };

        const PESAN = {
            sedang_dibuat:  { ikon: IKON.cangkir, judul: 'Pesananmu sedang dibuat', isi: 'Barista lagi meracik pesananmu', tujuan: URL_PESANAN },
            siap_disajikan: { ikon: IKON.lonceng, judul: 'Pesananmu sudah jadi',    isi: 'Segera diantar ke mejamu',       tujuan: URL_PESANAN },
            siap_diambil:   { ikon: IKON.tas,     judul: 'Pesananmu siap diambil',  isi: 'Silakan ambil pesananmu',        tujuan: URL_PESANAN },
            selesai:        { ikon: IKON.bintang, judul: 'Pesananmu selesai',       isi: 'Kasih rating yuk',               tujuan: URL_RIWAYAT }
        };

        // Status terakhir yang sudah diberitahukan disimpan di browser, supaya
        // pindah halaman tidak memunculkan notifikasi yang sama dua kali.
        let penyimpananRusak = false;
        let cadangan = {};

        function baca() {
            if (penyimpananRusak) return cadangan;
            try {
                return JSON.parse(localStorage.getItem(KUNCI) || '{}') || {};
            } catch (e) {
                penyimpananRusak = true;
                return cadangan;
            }
        }

        function simpan(data) {
            cadangan = data;
            try {
                localStorage.setItem(KUNCI, JSON.stringify(data));
            } catch (e) {
                penyimpananRusak = true;
            }
        }

        // Browser hanya mengizinkan suara setelah customer benar-benar mengetuk
        // halaman (menggulir saja tidak dihitung). Pemanasan audio dicoba pada
        // setiap ketukan sampai berhasil, lalu pendengarnya dilepas.
        let konteksAudio = null;
        const EVENT_PEMANASAN = ['pointerup', 'click', 'touchend', 'keydown'];

        function lepasPemanasan() {
            EVENT_PEMANASAN.forEach(function (nama) {
                document.removeEventListener(nama, siapkanAudio);
            });
        }

        function siapkanAudio() {
            try {
                const AC = window.AudioContext || window.webkitAudioContext;
                if (!AC) return;
                if (!konteksAudio) konteksAudio = new AC();

                if (konteksAudio.state === 'running') {
                    lepasPemanasan();
                    return;
                }

                const hasil = konteksAudio.resume();
                if (hasil && hasil.then) {
                    hasil.then(function () {
                        if (konteksAudio.state === 'running') lepasPemanasan();
                    }).catch(function () { /* coba lagi pada ketukan berikutnya */ });
                }
            } catch (e) { /* tidak didukung, abaikan */ }
        }

        EVENT_PEMANASAN.forEach(function (nama) {
            document.addEventListener(nama, siapkanAudio, { passive: true });
        });

        function bunyi() {
            try {
                if (!konteksAudio || konteksAudio.state !== 'running') return;

                const mulai = konteksAudio.currentTime;
                [[880, 0], [1175, 0.16]].forEach(function (nada) {
                    const osilator = konteksAudio.createOscillator();
                    const penguat = konteksAudio.createGain();
                    const awal = mulai + nada[1];

                    osilator.type = 'sine';
                    osilator.frequency.value = nada[0];
                    penguat.gain.setValueAtTime(0.0001, awal);
                    penguat.gain.exponentialRampToValueAtTime(0.18, awal + 0.02);
                    penguat.gain.exponentialRampToValueAtTime(0.0001, awal + 0.35);

                    osilator.connect(penguat);
                    penguat.connect(konteksAudio.destination);
                    osilator.start(awal);
                    osilator.stop(awal + 0.4);
                });
            } catch (e) { /* abaikan */ }
        }

        function tampilkan(kode, p) {
            const wadah = document.getElementById('rr-notif-wadah');

            while (wadah.children.length >= MAKS_TAMPIL) {
                wadah.removeChild(wadah.firstChild);
            }

            const kotak = document.createElement('div');
            kotak.className = 'rr-notif';

            const isi = document.createElement('a');
            isi.className = 'rr-notif-isi';
            isi.href = p.tujuan;

            const ikon = document.createElement('span');
            ikon.className = 'rr-notif-ikon';
            ikon.innerHTML = p.ikon;

            const teks = document.createElement('span');
            teks.className = 'rr-notif-teks';
            const judul = document.createElement('strong');
            judul.textContent = p.judul;
            const sub = document.createElement('small');
            sub.textContent = p.isi + ' · ' + kode;
            teks.appendChild(judul);
            teks.appendChild(sub);

            isi.appendChild(ikon);
            isi.appendChild(teks);

            const tutup = document.createElement('button');
            tutup.type = 'button';
            tutup.className = 'rr-notif-tutup';
            tutup.setAttribute('aria-label', 'Tutup');
            tutup.textContent = '×';
            tutup.addEventListener('click', function () { kotak.remove(); });

            kotak.appendChild(isi);
            kotak.appendChild(tutup);
            wadah.appendChild(kotak);

            setTimeout(function () { kotak.remove(); }, LAMA_TAMPIL_MS);

            try {
                bunyi();
                if (navigator.vibrate) navigator.vibrate([150, 80, 150]);
            } catch (e) { /* tidak didukung, abaikan */ }
        }

        function proses(pesanan) {
            const lama = baca();
            const baru = {};

            Object.keys(pesanan).forEach(function (kode) {
                const status = pesanan[kode];
                let sebelumnya = lama[kode];

                // Pesanan yang belum pernah dicatat dianggap mulai dari "baru".
                // Pesanan lama yang sudah selesai dicatat diam-diam, supaya tidak
                // memunculkan notifikasi usang.
                if (sebelumnya === undefined) {
                    sebelumnya = (status === 'selesai') ? 'selesai' : 'baru';
                }

                if (status !== sebelumnya && PESAN[status]) {
                    tampilkan(kode, PESAN[status]);
                }

                baru[kode] = status;
            });

            simpan(baru);
        }

        function cek() {
            if (document.hidden) return;

            fetch(URL_STATUS, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            })
                .then(function (res) { return res.ok ? res.json() : null; })
                .then(function (data) {
                    if (data && data.pesanan) proses(data.pesanan);
                })
                .catch(function () { /* diam saja, coba lagi di putaran berikutnya */ });
        }

        setTimeout(cek, 1500);
        setInterval(cek, INTERVAL_MS);

        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) cek();
        });
    })();
</script>