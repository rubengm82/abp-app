@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Llista de professionals</h1>
<div class="flex justify-end">
    <a href="{{ route('professionals.downloadCSV', ['status' => 1]) }}" class="link link-warning text-right">Descarregar Llista</a>
    <span class="mx-2"></span>
    <a href="{{ route('professionals.downloadCSVlockers') }}" class="link link-warning text-right">Descarregar Taquilles</a>
</div>

<div class="max-w-full mx-auto bg-white p-6 rounded shadow overflow-x-auto">
    
    <table class="table table-xs">
        <thead>
            <tr>
                <th>ID</th>
                <th>Centre</th>
                <th>Codi</th>
                <th>Nom</th>
                <th>Primer cognom</th>
                <th>Segon cognom</th>
                <th>DNI</th>
                <th>Adreça</th>
                <th>Rol</th>
                <th>Telèfon</th>
                <th>Email</th>
                <th>Samarreta</th>
                <th>Pantaló</th>
                <th>Sabata</th>
                <th>Estat</th>
                <th></th>
            </tr>
        </thead>
        @foreach ($professionals as $professional)
        <tbody>
            <!-- TODO: Añadir contorl de overflow-->
            @if ($professional->status == 1)
            <tr class="hover:bg-base-300">
                <th>{{ $professional->id }}</th>
                <td>{{ $professional->center_id }}</td>
                <!-- TODO: Añadir hover a codi -->
                <td>{{ $professional->key_code }}</td>
                <td>{{ $professional->name }}</td>
                <td>{{ $professional->surname1 }} </td>
                <td>{{ $professional->surname2 }}</td>
                <td>{{ $professional->dni }}</td>
                <td>{{ $professional->address }}</td>
                <td>{{ $professional->role }}</td>
                <td>{{ $professional->phone }}</td>
                <td>{{ $professional->email }}</td>
                <td>{{ $professional->shirt_size }}</td>
                <td>{{ $professional->pants_size }}</td>
                <td>{{ $professional->shoe_size }}</td>
                <td>
                    <span class="badge {{ $professional->employment_status === 'Actiu' ? 'badge-success' : 'badge-warning' }}">
                        {{ $professional->employment_status }}
                    </span>
                </td>
                <td class="flex justify-end gap-2">
                    <a href="{{ route('professional_edit', $professional->id) }}" class="btn btn-sm btn-info">Editar</a>
                    <a href="{{ route('professional_desactivate', $professional->id) }}" class="btn btn-sm btn-error">Desactivar</a>
                </td>
                </tr>
            @endif
        </tbody>
        @endforeach
    </table>
    @if (session('success_updated'))
        <div class="toast toast-end">
            <div class="alert alert-success">
                <span>{{ session('success_updated') }}</span>
            </div>
        </div>
    @endif
    @if (session('success_desactivated'))
        <div class="toast toast-end">
            <div class="alert alert-success">
                <span>{{ session('success_desactivated') }}</span>
            </div>
        </div>
    @endif
    
</div>



@endsection
