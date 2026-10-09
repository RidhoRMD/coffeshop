<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Meja Sedang Digunakan</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.webp') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {hu
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(145deg, #f3f0eb 0%, #e8e3dc 100%);
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      padding: 1.5rem;
      margin: 0;
    }

    .card {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 2.5rem;
      padding: 2.8rem 2.5rem;
      max-width: 460px;
      width: 100%;
      text-align: center;
      box-shadow: 
        0 30px 60px -20px rgba(20, 12, 8, 0.25),
        0 8px 20px rgba(0, 0, 0, 0.04),
        inset 0 1px 1px rgba(255, 255, 255, 0.6);
      border: 1px solid rgba(255, 255, 255, 0.5);
      transition: transform 0.25s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 40px 70px -18px rgba(30, 18, 10, 0.3);
    }

    /* icon dengan gradient & glowing */
    .icon-wrapper {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 96px;
      height: 96px;
      border-radius: 60px;
      background: linear-gradient(135deg, #f0eae3, #e1d7ce);
      margin-bottom: 1.5rem;
      box-shadow: 0 12px 28px -8px rgba(80, 50, 30, 0.15), inset 0 2px 4px rgba(255, 255, 255, 0.7);
      transition: all 0.2s;
    }

    .icon-wrapper i {
      font-size: 3.6rem;
      color: #4d3425;
      filter: drop-shadow(0 4px 6px rgba(60, 40, 25, 0.1));
    }

    h2 {
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      font-size: 2rem;
      letter-spacing: -0.02em;
      color: #1f140e;
      margin-bottom: 0.5rem;
      line-height: 1.2;
    }

    .subhead {
      font-size: 0.9rem;
      font-weight: 500;
      color: #8b7a6b;
      letter-spacing: 0.3px;
      text-transform: uppercase;
      margin-bottom: 1.2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .subhead span {
      background: #d9d0c6;
      width: 24px;
      height: 2px;
      border-radius: 4px;
      display: inline-block;
    }

    .desc {
      font-size: 0.98rem;
      line-height: 1.6;
      color: #4c3f35;
      max-width: 340px;
      margin: 0 auto 1.8rem auto;
      font-weight: 400;
      background: rgba(245, 240, 235, 0.5);
      padding: 0.6rem 1.2rem;
      border-radius: 60px;
      backdrop-filter: blur(4px);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .table-pill {
      display: inline-flex;
      align-items: center;
      gap: 0.6rem;
      background: #2d1e14;
      color: #f3ede8;
      padding: 0.7rem 1.8rem 0.7rem 1.6rem;
      border-radius: 60px;
      font-weight: 600;
      font-size: 1rem;
      letter-spacing: 0.5px;
      box-shadow: 0 6px 14px rgba(40, 25, 15, 0.25);
      transition: 0.2s ease;
      border: 1px solid rgba(255, 215, 180, 0.15);
    }

    .table-pill i {
      font-size: 1.1rem;
      color: #dbbdab;
    }

    .table-pill strong {
      font-weight: 700;
      color: #fff5ed;
    }

    .action-row {
      margin-top: 2.2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.6rem;
      font-family: 'Inter', sans-serif;
      font-weight: 500;
      font-size: 0.9rem;
      padding: 0.65rem 1.6rem;
      border-radius: 60px;
      text-decoration: none;
      background: transparent;
      border: 1px solid #d4c8bc;
      color: #3f3228;
      transition: all 0.2s;
      cursor: default;
      background: rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(2px);
    }

    .btn-primary {
      background: #2d1e14;
      border-color: #2d1e14;
      color: white;
      box-shadow: 0 4px 12px rgba(40, 25, 15, 0.15);
    }

    .btn-primary i {
      color: #dbbdab;
    }

    .btn-primary:hover {
      background: #1f130c;
      border-color: #1f130c;
      transform: scale(0.97);
      box-shadow: 0 8px 18px rgba(30, 18, 10, 0.2);
    }

    .btn-outline {
      border-color: #d0c2b6;
      color: #4d3d31;
    }

    .btn-outline i {
      color: #8b7767;
    }

    .btn-outline:hover {
      background: rgba(45, 30, 20, 0.04);
      border-color: #b8a699;
    }

    /* dekorasi kecil */
    .deco-dot {
      display: flex;
      justify-content: center;
      gap: 0.6rem;
      margin-top: 2rem;
      opacity: 0.6;
    }
    .deco-dot span {
      width: 6px;
      height: 6px;
      border-radius: 20px;
      background: #b7a79a;
    }
    .deco-dot span:first-child {
      width: 20px;
      background: #8f7a68;
    }

    /* responsif */
    @media (max-width: 480px) {
      .card {
        padding: 2rem 1.5rem;
        border-radius: 2rem;
      }
      .icon-wrapper {
        width: 76px;
        height: 76px;
      }
      .icon-wrapper i {
        font-size: 2.8rem;
      }
      h2 {
        font-size: 1.7rem;
      }
      .desc {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
      }
    }
  </style>
</head>
<body>

<div class="card">
  
  <!-- Icon dengan latar lembut -->
  <div class="icon-wrapper">
    <i class="fas fa-chair"></i>
  </div>

  <!-- Judul utama -->
  <h2>Meja Sedang Digunakan</h2>
  
  <!-- subhead dekoratif -->
  <div class="subhead">
    <span></span>  status  <span></span>
  </div>

  <!-- deskripsi ringkas -->
  <p class="desc">
    
    Meja ini sedang ditempati dan dipesan oleh pelanggan lain.
    
  </p>

  <!-- Nomer meja dengan icon & style premium -->
  <div class="table-pill">
    <i class="fas fa-hashtag" style="font-weight: 300;"></i>
    <strong>Meja {{ $meja->nomor_meja ?? '4' }}</strong>
    <i class="fas fa-lock" style="font-size: 0.75rem; opacity: 0.7; margin-left: 4px;"></i>
  </div>

  <!-- Tombol aksi (tidak aktif / informatif) -->
  <div class="action-row">
    
    
      <i class="fas fa-clock"></i> Coba Nanti
    </a>
  </div>

  <!-- dekorasi garis titik -->
 <!-- <div class="deco-dot">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
  </div>-->

</div>

<!-- (Catatan: variabel blade {{ $meja->nomor_meja }} tetap dipertahankan) -->
</body>
</html>