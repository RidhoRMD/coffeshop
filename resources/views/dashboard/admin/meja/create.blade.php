@extends('layouts.main')
@section('title','Tambah Meja')

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            Tambah Meja

        </h3>

    </div>

    <form action="{{ route('admin.meja.store') }}" method="POST">

        @csrf

        <div class="card-body">

            <div class="form-group">

                <label>Nomor Meja</label>

                <input
                type="number"
                class="form-control"
                value="{{ $nextNomor }}"
                readonly>
                <small class="form-text text-muted">
                    Nomor meja otomatis berurutan, tidak bisa diketik manual.
                </small>
            </div>

            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control">

                    <option value="kosong">

                        Kosong

                    </option>

                    <option value="dipesan">

                        Terisi

                    </option>

                    <option value="nonaktif">

                        Nonaktif

                    </option>

                </select>

            </div>

        </div>

        <div class="card-footer">
            <a href="{{ route('admin.meja.index') }}"
                class="btn btn-secondary">
                Kembali
            </a>

            <button class="btn btn-primary">

                Simpan

            </button>

        </div>

    </form>

</div>

@endsection