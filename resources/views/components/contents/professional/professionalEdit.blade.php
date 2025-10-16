@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Editar professional</h1>

<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <!-- Mostrar errores de validación -->
    @if ($errors->any())
        <div class="alert alert-error mb-4">
            <div>
                <div>
                    <h3 class="font-bold">Hi ha errors en el formulari:</h3>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('professional_update', $professional->id) }}" method="post" class="space-y-4">
        @csrf

        <!-- Campos del formulario -->
        <input type="text" name="name" id="id_name" placeholder="Nom" class="input input-bordered w-full" value="{{ old('name', $professional->name) }}" required>
        <input type="text" name="surname1" id="id_surname1" placeholder="Primer cognom" class="input input-bordered w-full" value="{{ old('surname1', $professional->surname1) }}" required>
        <input type="text" name="surname2" id="id_surname2" placeholder="Segon cognom" class="input input-bordered w-full" value="{{ old('surname2', $professional->surname2) }}">
        <input type="text" name="dni" id="id_dni" placeholder="DNI" class="input input-bordered w-full" value="{{ old('dni', $professional->dni) }}" required>

        <select name="role" id="id_role" class="select select-bordered w-full">
            <option value="">Rol del professional</option>
            <option value="Directiu" {{ old('role', $professional->role) == 'Directiu' ? 'selected' : '' }}>Directiu</option>
            <option value="Administració" {{ old('role', $professional->role) == 'Administració' ? 'selected' : '' }}>Administració</option>
            <option value="Tècnic" {{ old('role', $professional->role) == 'Tècnic' ? 'selected' : '' }}>Tècnic</option>
        </select>

        <select name="employment_status" id="id_employment_status" class="select select-bordered w-full">
            <option value="">Estat de treball</option>
            <option value="Actiu" {{ old('employment_status', $professional->employment_status) == 'Actiu' ? 'selected' : '' }}>Actiu</option>
            <option value="Suplència" {{ old('employment_status', $professional->employment_status) == 'Suplència' ? 'selected' : '' }}>Suplència</option>
            <option value="Baixa" {{ old('employment_status', $professional->employment_status) == 'Baixa' ? 'selected' : '' }}>Baixa</option>
            <option value="No contractat" {{ old('employment_status', $professional->employment_status) == 'No contractat' ? 'selected' : '' }}>No contractat</option>
        </select>

        <input type="text" name="phone" id="id_phone" placeholder="Telèfon" class="input input-bordered w-full" value="{{ old('phone', $professional->phone) }}">
        <input type="email" name="email" id="id_email" placeholder="Correu electrònic" class="input input-bordered w-full" value="{{ old('email', $professional->email) }}">
        <input type="text" name="address" id="id_address" placeholder="Adreça" class="input input-bordered w-full" value="{{ old('address', $professional->address) }}">
        <input type="text" name="key_code" id="id_key_code" placeholder="Codi de clau" class="input input-bordered w-full" value="{{ old('key_code', $professional->key_code) }}">
        <textarea name="cvitae" id="id_cvitae" rows="4" placeholder="Currículum Vitae..." class="textarea textarea-bordered w-full">{{ old('cvitae', $professional->cvitae) }}</textarea>


        <input type="text" name="user" id="id_user" placeholder="Nom d'usuari" class="input input-bordered w-full" value="{{ old('user', $professional->user) }}" autocomplete="off">
        <input type="password" name="password" id="id_password" placeholder="Contrasenya (deixar buit per mantenir l'actual)" class="input input-bordered w-full" autocomplete="new-password">

        <div class="flex gap-2 mt-4">
            <a href="{{ route('professionals_list') }}" class="btn flex-1">Cancel·lar</a>
            <input type="submit" value="Actualitzar" class="btn btn-info flex-1">
        </div>
    </form>
</div>

@include('components.layout.mainToasts')
@endsection
