@extends('app')

@section('title', 'Llistar centres desactivats')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Llista de centres desactivats</h1>

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
            @if ($center->status == 0)
                <tbody>
                <tr class="hover:bg-base-300">
                    <th>{{ $center->id }}</th>
                    <td>{{ $center->name }}</td>
                    <td>{{ $center->address }}</td>
                    <td>{{ $center->phone }}</td>
                    <td>{{ $center->email }}</td>
                    <td class="flex justify-end gap-2">
                        <a href="{{ route('center_activate', $center) }}" class="btn btn-sm btn-info">Activar</a>
                    </td>
                </tr>
            </tbody>
            @endif
        @endforeach
    </table>
    
    {{-- TOAST: SUCCESS ENABLED --}}
    @if (session('success_activated'))
        <div class="toast toast-end">
            <div class="alert alert-success">
                <span>{{ session('success_activated') }}</span>
            </div>
        </div>
    @endif

</div>

@endsection
