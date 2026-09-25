@extends('layouts.main')
@section('title', 'Pesanan Baru')

@section('content')

<style>
    .pilih-jenis-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        max-width: 820px;
        margin: 8px auto 0;
    }
    .pilih-jenis-card {
        background: #fff;
        border-radius: 18px;
        padding: 40px 28px;
        text-align: center;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(41,28,14,0.06);
        border: 1px solid rgba(41,28,14,0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    .pilih-jenis-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(41,28,14,0.12);
        border-color: var(--tan, #A78D78);
        text-decoration: none;
    }
    .pilih-jenis-card .ikon-wrap {
        width: 78px;
        height: 78px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 30px;
        transition: transform 0.2s ease;
    }
    .pilih-jenis-card:hover .ikon-wrap {
        transform: scale(1.08);
    }
    .pilih-jenis-card.dine-in .ikon-wrap {
        background: rgba(110, 71, 59, 0.1);
        color: var(--brown, #6E473B);
    }
    .pilih-jenis-card.take-away .ikon-wrap {
        background: rgba(76, 175, 80, 0.12);
        color: #4CAF50;
    }
    .pilih-jenis-card h4 {
        font-size: 19px;
        font-weight: 700;
        color: var(--dark, #291C0E);
        margin-bottom: 6px;
    }
    .pilih-jenis-card p {
        font-size: 13px;
        color: #9a8c7c;
        margin-bottom: 0;
    }
    .pilih-jenis-card .panah {
        position: absolute;
        top: 20px;
        right: 22px;
        color: #ddd;
        font-size: 14px;
        transition: transform 0.2s ease, color 0.2s ease;
    }
    .pilih-jenis-card:hover .panah {
        color: var(--brown, #6E473B);
        transform: translateX(4px);
    }

    @media (max-width: 576px) {
        .pilih-jenis-grid {
            grid-template-columns: 1fr;
        }
        .pilih-jenis-card {
            padding: 32px 20px;
        }
    }
</style>

<div class="pilih-jenis-grid">
    <a href="{{ route('kasir.pesanan.create.dinein') }}" class="pilih-jenis-card dine-in">
        <i class="fas fa-arrow-right panah"></i>
        <div class="ikon-wrap">
            <i class="fas fa-chair"></i>
        </div>
        <h4>Dine In</h4>
        <p>Pelanggan makan di tempat</p>
    </a>

    <a href="{{ route('kasir.pesanan.create.takeaway') }}" class="pilih-jenis-card take-away">
        <i class="fas fa-arrow-right panah"></i>
        <div class="ikon-wrap">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <h4>Take Away</h4>
        <p>Pelanggan bawa pulang</p>
    </a>
</div>

@endsection