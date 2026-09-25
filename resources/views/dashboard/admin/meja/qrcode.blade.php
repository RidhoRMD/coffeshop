@extends('layouts.main')

@section('title', 'QR Code Meja')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h3 class="card-title mb-0">

            <i class="fas fa-qrcode"></i>
            QR Code Meja

        </h3>

        <span class="badge badge-primary p-2">

            Meja {{ $meja->nomor_meja }}

        </span>

    </div>

    <div class="card-body">

        <div class="row">

            {{-- Informasi --}}
            <div class="col-md-5">

                <table class="table table-bordered">

                    <tr>

                        <th width="40%">Nomor Meja</th>

                        <td>{{ $meja->nomor_meja }}</td>

                    </tr>

                    <tr>

                        <th>Kode QR</th>

                        <td>

                            <span class="badge badge-dark">

                                {{ $meja->kode_qr }}

                            </span>

                        </td>

                    </tr>

                    <tr>

                        <th>Status</th>

                        <td>

                            @if($meja->status == 'kosong')

                                <span class="badge badge-success">

                                    Kosong

                                </span>

                            @elseif($meja->status == 'dipesan')

                                <span class="badge badge-warning">

                                    Terisi

                                </span>

                            @else

                                <span class="badge badge-danger">

                                    Nonaktif

                                </span>

                            @endif

                        </td>

                    </tr>

                    <tr>

                        <th>Dibuat</th>

                        <td>

                            {{ $meja->created_at->format('d M Y H:i') }}

                        </td>

                    </tr>

                </table>

            </div>

            {{-- QR Code --}}
            <div class="col-md-7 text-center">

                {!! QrCode::size(330)->margin(2)->generate(
                    request()->getSchemeAndHttpHost() . '/order/' . $meja->kode_qr
                ) !!}

                <h4 class="mt-4">

                    Meja {{ $meja->nomor_meja }}

                </h4>

                <p class="text-muted">

                    {{ $meja->kode_qr }}

                </p>

            </div>

        </div>

    </div>

    <div class="card-footer text-center">

        <a href="{{ route('admin.meja.download',$meja->id) }}"
            class="btn btn-success">

            <i class="fas fa-download"></i>

            Download PNG

        </a>

        <a href="#"
            onclick="window.print()"
            class="btn btn-primary">

            <i class="fas fa-print"></i>

            Print

        </a>

        <a href="{{ route('admin.meja.index') }}"
            class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>

@endsection