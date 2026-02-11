@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Estoc de Material' => null,
    ]"
    :current="'Llistat d\'items'"
/>

<div class="max-w-4xl mx-auto bg-base-200 text-base-content p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl font-bold text-base-content underline underline-offset-5">Estoc de Material</h1>
        @if($items->count() > 0)
            <a href="{{ route('material_stock_items_downloadCSV') }}" class="btn btn-sm btn-success">Descarregar llistat</a>
        @endif
    </div>

    @if($items->count() > 0)
        <div class="scrollable-list-container">
            <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
                <div class="card-body p-4">
                    <div class="overflow-x-auto">
                        <table class="table table-sm w-full">
                            <thead>
                                <tr class="border-base-content/10">
                                    <th class="text-left font-semibold text-xs">Item</th>
                                    <th class="text-right font-semibold text-xs">Quantitat disponible</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr class="border-base-content/10">
                                        <td class="text-base-content/80">{{ $item->name }}</td>
                                        <td class="text-right font-medium">
                                            @if($item->quantity < 0)
                                                <span class="font-bold text-error">{{ $item->quantity }}</span>
                                            @else
                                                {{ $item->quantity }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-xl font-bold text-base-content mb-2">Encara no hi ha items d'estoc</h3>
            <p class="text-base-content/70 mb-4">Afegiu un tipus d'item per començar.</p>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
