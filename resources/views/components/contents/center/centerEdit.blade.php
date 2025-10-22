@extends('app')

@section('content')

@include('components.partials.breadcrumb', [
    'items' => [
        'Centres' => route('centers_list'),
        'Llistat' => route('centers_list'),
        'Detalls' => route('center_show', $center),
    ],
    'current' => 'Editar'
])
<div class="max-w-4xl mx-auto bg-base-100 p-6 rounded shadow">
    <h1 class="text-3xl font-bold text-base-content mb-6 text-center">Editar centre</h1>
    
    <form action="{{ route('center_update', $center) }}" method="post" class="space-y-6">
        @csrf

        <!-- Center Information -->
        <div class="card shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació del Centre</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nom del centre *</span>
                        </label>
                        <input type="text" name="name" id="id_name" placeholder="Ex: Centre Barcelona Nord" class="input input-bordered w-full" value="{{ old('name', $center->name) }}" required>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Telèfon</span>
                        </label>
                        <input type="text" name="phone" id="id_phone" placeholder="Ex: 93 123 45 67" class="input input-bordered w-full" value="{{ old('phone', $center->phone) }}">
                    </div>
                    
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text">Adreça</span>
                        </label>
                        <input type="text" name="address" id="id_address" placeholder="Ex: Carrer Major, 123, Barcelona" class="input input-bordered w-full" value="{{ old('address', $center->address) }}">
                    </div>
                    
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text">Correu electrònic</span>
                        </label>
                        <input type="email" name="email" id="id_email" placeholder="Ex: info@centrebarcelonanord.com" class="input input-bordered w-full" value="{{ old('email', $center->email) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('centers_list') }}" class="btn btn-outline">Cancel·lar</a>
            <input type="submit" value="Actualitzar Centre" class="btn btn-info">
        </div>
    </form>
</div>

@include('components.partials.mainToasts')
@endsection
