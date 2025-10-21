@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Editar centre</h1>

<div class="max-w-lg mx-auto bg-base-100 p-6 rounded shadow">
    <form action="{{ route('center_update', $center) }}" method="post" class="space-y-4">
        @csrf
        <input type="text" name="name" id="id_name" placeholder="Nom" value="{{ old('name', $center->name) }}" class="input input-bordered w-full">
        <input type="text" name="address" id="id_address" placeholder="Adreça" value="{{ old('name', $center->address) }}" class="input input-bordered w-full">
        <input type="text" name="phone" id="id_phone" placeholder="Telèfon" value="{{ old('name', $center->phone) }}" class="input input-bordered w-full">
        <input type="text" name="email" id="id_email" placeholder="Email" value="{{ old('name', $center->email) }}" class="input input-bordered w-full">
        
        <div class="flex justify-end gap-2">
            <input type="submit" value="Actualitzar" class="btn btn-info">
        </div>
    </form>
</div>

@include('components.partials.mainToasts')
@endsection
