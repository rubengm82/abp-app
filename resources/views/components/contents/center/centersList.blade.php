@extends('app')

@section('title', 'Llistar centres')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Llista de centres</h1>
<div class="flex justify-end">
    <a href="{{ route('centers.downloadCSV', ['status' => 1]) }}" class="link link-warning text-right">Descarregar Llista</a>
</div>

<div class="max-w-full mx-auto bg-white p-6 rounded shadow overflow-x-auto">
    
    <table class="table table-xs">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Adreça</th>
                <th>Telèfon</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        @foreach ($centers as $center)
            @if ($center->status == 1)
                <tbody>
                <tr class="hover:bg-base-300">
                    <th>{{ $center->id }}</th>
                    <td>{{ $center->name }}</td>
                    <td>{{ $center->address }}</td>
                    <td>{{ $center->phone }}</td>
                    <td>{{ $center->email }}</td>
                    <td class="flex justify-end gap-2">
                        <a href="" class="btn btn-sm btn-info">Editar</a>
                        <a href="{{ route('center_desactivate', $center) }}" class="btn btn-sm btn-error">Desactivar</a>
                    </td>
                </tr>
            </tbody>
            @endif
        @endforeach
    </table>
    
    {{-- TOAST: SUCCESS DISABLED --}}
    @if (session('success_desactivated'))
        <div class="toast toast-end">
            <div class="alert alert-success">
                <span>{{ session('success_desactivated') }}</span>
            </div>
        </div>
    @endif

</div>

@endsection
