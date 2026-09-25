@extends('layouts.main')
@section('title', 'Dashboard Barista')

@section('content')

<!--<div class="card mb-4">
    <div class="card-body">
        <h4 class="mb-0">Selamat datang, {{ auth()->user()->name }} (Barista)</h4>
    </div>
</div>-->

<div class="row">
    <div class="col-md-4">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $jumlahBaru }}</h3>
                <p>Pesanan Baru</p>
            </div>
            <div class="icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <a href="{{ route('barista.pesanan.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $jumlahDiproses }}</h3>
                <p>Sedang Dibuat</p>
            </div>
            <div class="icon">
                <i class="fas fa-mug-hot"></i>
            </div>
            <a href="{{ route('barista.pesanan.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $jumlahSiap }}</h3>
                <p>Siap Disajikan/Diambil</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="{{ route('barista.pesanan.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

@endsection