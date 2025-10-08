@extends('app')

@section('title', 'Llistar professionals')

@section('content')
<div class="max-w-full mx-auto bg-white p-6 rounded shadow overflow-x-auto">
    <!-- TODO: Review this alert -->
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    <table class="table table-xs">
        <thead>
            <tr>
                <!-- <th>ID</th> -->
                <th>Centre</th>
                <!-- <th>Codi</th> -->
                <th>Nom</th>
                <th>Cognoms</th>
                <th>DNI</th>
                <th>Adreça</th>
                <th>Rol</th>
                <th>Telèfon</th>
                <th>Email</th>
                <th>Estat</th>
                <th></th>
            </tr>
        </thead>
        @foreach ($professionals as $professional)
            <tbody>
            <tr class="hover:bg-base-300">
                <!-- <th>{{ $professional->id }}</th> -->
                <td>{{ $professional->center_id }}</td>
                <!-- <td>{{ $professional->key_code }}</td> -->
                <td>{{ $professional->name }}</td>
                <td>{{ $professional->surname1 }} {{ $professional->surname2 }}</td>
                <td>{{ $professional->dni }}</td>
                <td>{{ $professional->address }}</td>
                <td>{{ $professional->role }}</td>
                <td>{{ $professional->phone }}</td>
                <td>{{ $professional->email }}</td>
                <td>
                    <span class="badge {{ $professional->employment_status === 'Actiu' ? 'badge-success' : 'badge-warning' }}">
                        {{ $professional->employment_status }}
                    </span>
                </td>
                <td class="flex justify-end gap-2">
                    <a href="{{ route('professional_edit', $professional->id) }}" class="btn btn-sm btn-info">Editar</a>
                    <a href="" class="btn btn-sm btn-error">Borrar</a>
                </td>
            </tr>
        </tbody>
        @endforeach
    </table>
    
</div>

@endsection
