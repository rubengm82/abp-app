@extends('app')

@section('title', 'Llistar centres')

@section('content')
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
                        <a href="" class="btn btn-sm btn-error">Borrar</a>
                    </td>
                </tr>
            </tbody>
            @endif
        @endforeach
    </table>
    
</div>

@endsection
