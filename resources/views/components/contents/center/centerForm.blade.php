@extends('app')

@section('title', 'Afegir centre')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Afegir centre</h2>

    <form action="{{ route('center_add') }}" method="post" class="space-y-4">
        @csrf
        <input type="text" name="name" id="id_name" placeholder="Nom" class="input input-bordered w-full" required>
        <input type="text" name="address" id="id_address" placeholder="Adreça" class="input input-bordered w-full">
        <input type="text" name="phone" id="id_phone" placeholder="Telèfon" class="input input-bordered w-full">
        <input type="text" name="email" id="id_email" placeholder="Email" class="input input-bordered w-full">

        <div class="flex gap-2">
            <input type="submit" value="Acceptar" class="btn btn-primary flex-1">
            <input type="reset" value="Reset" class="btn flex-1">
        </div>
    </form>
</div>
@endsection
