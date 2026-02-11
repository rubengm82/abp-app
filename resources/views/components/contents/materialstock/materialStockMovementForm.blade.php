@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Estoc de Material' => route('material_stock_items_list'),
        'Registre de moviments' => route('material_stock_movements_list'),
    ]"
    :current="'Fer moviment'"
/>

<div class="max-w-4xl mx-auto bg-base-200 p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <h1 class="text-3xl font-bold text-base-content mb-6 text-center">Fer moviment</h1>

    @if ($errors->any())
        <div class="alert alert-error mb-6">
            <div>
                <h3 class="font-bold text-base-content mb-1">Hi ha errors en el formulari:</h3>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-warning mb-6">{{ session('error') }}</div>
    @endif

    <form action="{{ route('material_stock_movement_add') }}" method="post" class="space-y-6" id="form_movement">
        @csrf
        <input type="hidden" id="confirmed_negative" value="0">

        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Dades del moviment</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Tipus *</span>
                        </label>
                        <select name="type" id="id_type" class="select select-bordered w-full" required>
                            <option value="">Selecciona tipus</option>
                            <option value="Entrada" {{ old('type') == 'Entrada' ? 'selected' : '' }}>Entrada</option>
                            <option value="Sortida" {{ old('type') == 'Sortida' ? 'selected' : '' }}>Sortida</option>
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Item *</span>
                        </label>
                        <select name="material_stock_item_id" id="id_material_stock_item_id" class="select select-bordered w-full" required>
                            <option value="">Selecciona item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" data-quantity="{{ $item->quantity }}" {{ old('material_stock_item_id') == $item->id ? 'selected' : '' }}>{{ $item->name }} (estoc: {{ $item->quantity }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Quantitat *</span>
                        </label>
                        <input type="number" name="quantity" id="id_quantity" min="1" class="input input-bordered w-full" value="{{ old('quantity', 1) }}" required>
                    </div>
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Data *</span>
                        </label>
                        <input type="date" name="movement_date" id="id_movement_date" class="input input-bordered w-full" value="{{ old('movement_date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="form-control md:col-span-2">
                        <label class="label font-bold text-base-content mb-1" id="label_person">
                            <span class="label-text">Persona</span>
                        </label>
                        <input type="text" name="person" id="id_person" placeholder="Proveedor (entrada) o persona receptora (sortida)" class="input input-bordered w-full" value="{{ old('person') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('material_stock_movements_list') }}" class="btn btn-outline">Cancel·lar</a>
            <input type="submit" value="Registrar moviment" class="btn btn-info" id="btn_submit">
        </div>
    </form>

    {{-- Modal: confirm when sortida would result in negative quantity (triggered by JS, trigger label hidden) --}}
    <x-partials.modal id="modal_negative_quantity" msj="La quantitat resultant seria negativa. Voleu continuar?" btnText="" class="hidden">
        <button type="button" class="btn btn-sm btn-warning" id="btn_confirm_negative">Acceptar</button>
    </x-partials.modal>
</div>

<script src="{{ asset('js/components/partials/material-stock-movement-form.js') }}"></script>

@include('components.partials.mainToasts')
@endsection
