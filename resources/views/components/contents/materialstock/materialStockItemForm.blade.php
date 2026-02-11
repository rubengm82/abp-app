@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Estoc de Material' => route('material_stock_items_list'),
    ]"
    :current="'Nou Item'"
/>

<div class="max-w-4xl mx-auto bg-base-200 p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <h1 class="text-3xl font-bold text-base-content mb-6 text-center">Nou Item</h1>

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

    <form action="{{ route('material_stock_item_add') }}" method="post" class="space-y-6">
        @csrf

        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Dades de l'item</h2>
                <div class="form-control">
                    <label class="label font-bold text-base-content mb-1">
                        <span class="label-text">Nom *</span>
                    </label>
                    <input type="text" name="name" id="id_name" placeholder="Ex: Roba uniforme M" class="input input-bordered w-full" value="{{ old('name') }}" required>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('material_stock_items_list') }}" class="btn btn-outline">Cancel·lar</a>
            <input type="submit" value="Afegir Item" class="btn btn-info">
        </div>
    </form>
</div>

@include('components.partials.mainToasts')
@endsection
