@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Llista de projectes i comissions desactivats</h1>
<div class="flex justify-end">
    <a href="{{ route('projectcommissions.downloadCSV', ['status' => 'Inactiu']) }}" class="link link-warning text-right">Descarregar Llista</a>
</div>

<div class="max-w-full mx-auto bg-white p-6 rounded shadow overflow-x-auto">
    
    <table class="table table-xs">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom/Títol</th>
                <th>Estat</th>
                <th>Professional responsable</th>
                <th>Tipus</th>
                <th>Data d'inici</th>
            </tr>
        </thead>
        @foreach ($projectCommissions as $projectCommission)
            @if ($projectCommission->status == 'Inactiu')
                <tbody>
                <tr class="hover:bg-base-300">
                    <th>{{ $projectCommission->id }}</th>
                    <td>
                        <a href="{{ route('projectcommission_show', $projectCommission) }}" class="link link-primary">
                            {{ $projectCommission->name }}
                        </a>
                    </td>
                    <td>{{ $projectCommission->status}}</td>
                    <td>{{ $projectCommission->responsibleProfessional ? $projectCommission->responsibleProfessional->name . ' ' . $projectCommission->responsibleProfessional->surname1 : '' }}</td>
                    <td>{{ $projectCommission->type }}</td>
                    <td>{{ $projectCommission->start_date}}</td>
                </tr>
            </tbody>
            @endif
        @endforeach
    </table>
    
</div>

@endsection
