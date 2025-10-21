@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Afegir centre</h1>

<div class="max-w-lg mx-auto bg-base-100 p-6 rounded shadow">
    <form action="{{ route('center_add') }}" method="post" class="space-y-4">
        @csrf
        <input type="text" name="name" id="id_name" placeholder="Nom" class="input input-bordered w-full" required>
        <input type="text" name="address" id="id_address" placeholder="Adreça" class="input input-bordered w-full">
        <input type="text" name="phone" id="id_phone" placeholder="Telèfon" class="input input-bordered w-full">
        <input type="text" name="email" id="id_email" placeholder="Email" class="input input-bordered w-full">
        
        <div class="flex gap-2">
            <input type="reset" value="Netejar" class="btn flex-1">
            <input type="submit" value="Crear Centre" class="btn btn-info flex-1">
        </div>
    </form>
</div>

@include('components.partials.mainToasts')
@endsection
