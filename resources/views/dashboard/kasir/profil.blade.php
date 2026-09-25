@extends('layouts.main')
@section('title', 'Profil')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card">
            <div class="card-body text-center">
                <img src="https://api.dicebear.com/9.x/notionists/svg?seed={{ urlencode($user->name) }}"
                    class="img-circle elevation-2" style="width:120px; height:120px; background:#f4f6f9;"
                    alt="Avatar">

                <h3 class="mt-3 mb-0">{{ $user->name }}</h3>
                <p class="text-muted">{{ $user->email }}</p>

                <span class="badge badge-primary">{{ ucfirst($user->role) }}</span>
            </div>

            <div class="card-footer">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th width="35%">Nama</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{ ucfirst($user->role) }}</td>
                    </tr>
                    <tr>
                        <th>Bergabung Sejak</th>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection