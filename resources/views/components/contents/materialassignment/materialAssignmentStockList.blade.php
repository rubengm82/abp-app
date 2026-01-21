@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Registre de Uniformitat' => route('materialassignments_list'),
    ]"
    :current="'Existencies de roba'"
/>
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Existencies de roba</h1>

<div class="flex justify-between items-center">
    <div>
    </div>
    <div class="flex gap-4">
        <a href="{{ route('materialassignments_existencies_roba_download', $center->id) }}" class="btn btn-sm btn-success">Descarregar Existencies Roba</a>
    </div>
</div>

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg/10 overflow-x-auto border border-gray-500/20">
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Samarretas</th>
                    <th>Quantitat</th>
                    <th>Pantalons</th>
                    <th>Quantitat</th>
                    <th>Sabates</th>
                    <th>Quantitat</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < max(count($shirtSizes), count($pantsSizes), count($shoeSizes)); $i++)
                    <tr>
                        <td>{{ array_keys($shirtSizes)[$i] ?? '' }}</td>
                        <td>{{ (array_values($shirtSizes)[$i] ?? 0) > 0 ? array_values($shirtSizes)[$i] : '' }}</td>
                        <td>{{ array_keys($pantsSizes)[$i] ?? '' }}</td>
                        <td>{{ (array_values($pantsSizes)[$i] ?? 0) > 0 ? array_values($pantsSizes)[$i] : '' }}</td>
                        <td>{{ array_keys($shoeSizes)[$i] ?? '' }}</td>
                        <td>{{ (array_values($shoeSizes)[$i] ?? 0) > 0 ? array_values($shoeSizes)[$i] : '' }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>

@include('components.partials.mainToasts')
@endsection