@extends('layouts.main')
@section('title','Edit Meja')

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            Edit Meja

        </h3>

    </div>

    <form action="{{ route('admin.meja.update',$meja->id) }}"
        method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">

                    <label>Nomor Meja</label>

                    <input
                        type="number"
                        value="{{ $meja->nomor_meja }}"
                        class="form-control"
                        min="1"
                        max="100"
                        readonly>

                <script>
                document.querySelector('input[name="nomor_meja"]').addEventListener('input', function () {
                    if (this.value > 100) {
                        this.value = 100;
                    }
                    if (this.value < 1 && this.value !== '') {
                        this.value = 1;
                    }
                });
                </script>
            </div>

            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control">

                    <option value="kosong"
                        {{ $meja->status=='kosong'?'selected':'' }}>

                        Kosong

                    </option>

                    <option value="dipesan"
                        {{ $meja->status=='dipesan'?'selected':'' }}>

                        Terisi

                    </option>

                    <option value="nonaktif"
                        {{ $meja->status=='nonaktif'?'selected':'' }}>

                        Nonaktif

                    </option>

                </select>

            </div>

            <div class="form-group">

                <label>Kode QR</label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $meja->kode_qr }}"
                    readonly>

            </div>

        </div>

        <div class="card-footer">
            <a href="{{ route('admin.meja.index') }}"
                class="btn btn-secondary">
                Kembali
            </a>

            <button class="btn btn-primary">
                Update
            </button>

        </div>

    </form>

</div>

@endsection