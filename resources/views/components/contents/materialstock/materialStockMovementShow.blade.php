@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Estoc de Material' => route('material_stock_items_list'),
        'Registre de moviments' => route('material_stock_movements_list'),
    ]"
    :current="'Fitxa moviment'"
/>

<div class="max-w-4xl mx-auto bg-base-200 text-base-content p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <div class="flex justify-end items-center mb-6">
        <div class="flex gap-2">
            <x-partials.modal
                id="modal_cancel_movement_show"
                msj="Cancel·lar aquest moviment revertirà la quantitat a l'item (suma o resta inversa). Esteu segur?"
                btnText="Cancel·lar moviment"
                class="btn-sm btn-error"
            >
                <form action="{{ route('material_stock_movement_delete', $materialStockMovement) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-error">Acceptar</button>
                </form>
            </x-partials.modal>
        </div>
    </div>

    <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4 underline underline-offset-5">Dades del moviment</h2>
            <div class="space-y-3">
                <div>
                    <label class="font-bold text-md">Tipus:</label>
                    <p class="text-sm text-base-content/80">
                        <span class="badge badge-dash whitespace-nowrap {{ $materialStockMovement->type === 'Entrada' ? 'badge-success' : 'badge-warning' }}">
                            {{ $materialStockMovement->type }}
                        </span>
                    </p>
                </div>
                <div>
                    <label class="font-bold text-md">Item:</label>
                    <p class="text-sm text-base-content/80">{{ $materialStockMovement->materialStockItem->name ?? '' }}</p>
                </div>
                <div>
                    <label class="font-bold text-md">Quantitat:</label>
                    <p class="text-sm text-base-content/80">{{ $materialStockMovement->quantity }}</p>
                </div>
                <div>
                    <label class="font-bold text-md">Data:</label>
                    <p class="text-sm text-base-content/80">{{ $materialStockMovement->movement_date?->format('d/m/Y') }}</p>
                </div>
                <div>
                    <label class="font-bold text-md">{{ $materialStockMovement->type === 'Entrada' ? 'Proveedor' : 'Persona a qui es lliura' }}:</label>
                    <p class="text-sm text-base-content/80">{{ $materialStockMovement->person ?? '' }}</p>
                </div>
                <div>
                    <label class="font-bold text-md">Professional que ha fet el moviment:</label>
                    <p class="text-sm text-base-content/80">
                        @if($materialStockMovement->professional)
                            {{ $materialStockMovement->professional->name }} {{ $materialStockMovement->professional->surname1 }}
                        @else
                            —
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.partials.mainToasts')
@endsection
