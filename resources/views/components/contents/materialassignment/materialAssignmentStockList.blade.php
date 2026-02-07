@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Registre de Uniformitat' => route('materialassignments_list'),
    ]"
    :current="'Existències de roba'"
/>

<div class="max-w-4xl mx-auto bg-base-200 text-base-content p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    {{-- Header: title + action --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl font-bold text-base-content underline underline-offset-5">Existències de roba</h1>
        <a href="{{ route('materialassignments_existencies_roba_download', $center->id) }}" class="btn btn-sm btn-success">
            Descarregar existències
        </a>
    </div>

    {{-- Three sections in grid (same pattern as show pages) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Samarretes --}}
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body p-4">
                <h2 class="card-title text-lg underline underline-offset-5 mb-3">Samarretes</h2>
                @if(count($shirtSizes) > 0)
                    <div class="overflow-x-auto">
                        <table class="table table-sm">
                            <thead>
                                <tr class="border-base-content/10">
                                    <th class="text-left font-semibold text-xs">Talla</th>
                                    <th class="text-right font-semibold text-xs">Quantitat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shirtSizes as $size => $qty)
                                    <tr class="border-base-content/10">
                                        <td class="text-base-content/80">{{ $size }}</td>
                                        <td class="text-right font-medium">{{ $qty }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-base-content/50 italic">Sense dades</p>
                @endif
            </div>
        </div>

        {{-- Pantalons --}}
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body p-4">
                <h2 class="card-title text-lg underline underline-offset-5 mb-3">Pantalons</h2>
                @if(count($pantsSizes) > 0)
                    <div class="overflow-x-auto">
                        <table class="table table-sm">
                            <thead>
                                <tr class="border-base-content/10">
                                    <th class="text-left font-semibold text-xs">Talla</th>
                                    <th class="text-right font-semibold text-xs">Quantitat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pantsSizes as $size => $qty)
                                    <tr class="border-base-content/10">
                                        <td class="text-base-content/80">{{ $size }}</td>
                                        <td class="text-right font-medium">{{ $qty }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-base-content/50 italic">Sense dades</p>
                @endif
            </div>
        </div>

        {{-- Sabates --}}
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body p-4">
                <h2 class="card-title text-lg underline underline-offset-5 mb-3">Sabates</h2>
                @if(count($shoeSizes) > 0)
                    <div class="overflow-x-auto">
                        <table class="table table-sm">
                            <thead>
                                <tr class="border-base-content/10">
                                    <th class="text-left font-semibold text-xs">Talla</th>
                                    <th class="text-right font-semibold text-xs">Quantitat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shoeSizes as $size => $qty)
                                    <tr class="border-base-content/10">
                                        <td class="text-base-content/80">{{ $size }}</td>
                                        <td class="text-right font-medium">{{ $qty }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-base-content/50 italic">Sense dades</p>
                @endif
            </div>
        </div>
    </div>
</div>

@include('components.partials.mainToasts')
@endsection
