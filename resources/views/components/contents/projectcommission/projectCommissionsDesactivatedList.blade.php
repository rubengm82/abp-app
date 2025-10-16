@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Llista de projectes i comissions desactivats</h1>
@if($projectCommissions->where('status', 'Inactiu')->count() > 0)
<div class="flex justify-end gap-4">
    <a href="{{ route('projectcommissions.downloadCSV', ['status' => 'Inactiu']) }}" class="btn btn-sm btn-warning">Descarregar Llista</a>
</div>
@endif

<div class="max-w-full mx-auto bg-white p-6 rounded shadow overflow-x-auto">
    @if($projectCommissions->where('status', 'Inactiu')->count() > 0)
        <table class="table table-xs">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom/Títol</th>
                    <th>Estat</th>
                    <th>Professional responsable</th>
                    <th>Tipus</th>
                    <th>Data d'inici</th>
                    <th>Accions</th>
                </tr>
            </thead>
            @foreach ($projectCommissions as $projectCommission)
                @if ($projectCommission->status == 'Inactiu')
                    <tbody>
                    <tr class="hover:bg-base-300">
                        <th>{{ $projectCommission->id }}</th>
                        <td>{{ $projectCommission->name }}</td>
                        <td>{{ $projectCommission->status}}</td>
                        <td>{{ $projectCommission->responsibleProfessional ? $projectCommission->responsibleProfessional->name . ' ' . $projectCommission->responsibleProfessional->surname1 : '' }}</td>
                        <td>{{ $projectCommission->type }}</td>
                        <td>{{ $projectCommission->start_date}}</td>
                        <td class="flex justify-end gap-2">
                            <a href="{{ route('projectcommission_show', $projectCommission) }}" class="btn btn-sm btn-info">Veure</a>
                            <a href="{{ route('projectcommission_activate', $projectCommission) }}" class="btn btn-sm btn-success">Activar</a>
                        </td>
                    </tr>
                </tbody>
                @endif
            @endforeach
        </table>
    @else
    <!-- TODO: Mover el icono y utilizar el svg master -->
        <div class="text-center py-12">
            <div class="text-gray-400 text-lg mb-4">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No hi ha projectes/comissions desactivats</h3>
            <p class="text-gray-500 mb-4">Tots els projectes i comissions estan actualment actius.</p>
        </div>
    @endif
    
</div>

@include('components.layout.mainToasts')
@endsection
