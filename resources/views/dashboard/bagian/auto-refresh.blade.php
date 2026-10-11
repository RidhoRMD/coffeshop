@use('App\Services\TandaPembaruan')
@php
    $tanda = $tanda ?? TandaPembaruan::pesanan();
@endphp
<script>
    (function () {
        const URL_CEK = @json($urlCek);
        const INTERVAL_MS = 6000;
        let tandaSaatIni = @json($tanda);

        function sedangSibuk() {
            const el = document.activeElement;
            if (el && ['INPUT', 'TEXTAREA', 'SELECT'].includes(el.tagName)) return true;

            if (document.querySelector('.modal.show, .rr-confirm-overlay.show')) return true;

            if (window.jQuery && $.fn.dataTable && $.fn.dataTable.isDataTable('#example1')) {
                if ($('#example1').DataTable().search() !== '') return true;
            }

            return false;
        }

        function tampilkanNotice() {
            if (document.getElementById('rr-notice-baru')) return;

            const box = document.createElement('div');
            box.id = 'rr-notice-baru';
            box.style.cssText = 'position:fixed; right:20px; bottom:20px; z-index:1100; display:flex; align-items:center; gap:12px; padding:12px 16px; border-radius:12px; background:var(--brown,#6E473B); color:#fff; font-size:13px; box-shadow:0 10px 30px rgba(41,28,14,0.25);';
            box.innerHTML = '<span>Ada pesanan baru atau perubahan status.</span>' +
                '<button type="button" style="border:none; border-radius:8px; padding:6px 12px; font-weight:600; cursor:pointer; background:#fff; color:#291C0E;">Muat ulang</button>';
            box.querySelector('button').addEventListener('click', function () {
                location.reload();
            });
            document.body.appendChild(box);
        }

        function cekPembaruan() {
            if (document.hidden) return;

            fetch(URL_CEK, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            })
                .then(function (res) { return res.ok ? res.json() : null; })
                .then(function (data) {
                    if (!data || data.tanda === tandaSaatIni) return;

                    if (sedangSibuk()) {
                        tampilkanNotice();
                    } else {
                        location.reload();
                    }
                })
                .catch(function () { /* diam saja, coba lagi di putaran berikutnya */ });
        }

        setInterval(cekPembaruan, INTERVAL_MS);

        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) cekPembaruan();
        });
    })();
</script>