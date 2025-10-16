@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Afegir professional</h1>

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

    <form action="{{ route('professional_add') }}" method="post" class="space-y-4">
        @csrf

        <!-- Campos del formulario -->
        <input type="text" name="name" id="id_name" placeholder="Nom" class="input input-bordered w-full" value="{{ old('name') }}" required>
        <input type="text" name="surname1" id="id_surname1" placeholder="Primer cognom" class="input input-bordered w-full" value="{{ old('surname1') }}" required>
        <input type="text" name="surname2" id="id_surname2" placeholder="Segon cognom" class="input input-bordered w-full" value="{{ old('surname2') }}">
        <input type="text" name="dni" id="id_dni" placeholder="DNI" class="input input-bordered w-full" value="{{ old('dni') }}" required>

        <label for="id_role" class="label">
            <span class="label-text">Rol del professional</span>
        </label>
        <select name="role" id="id_role" class="select select-bordered w-full">
            <option value=""></option>
            <option value="Directiu" {{ old('role') == 'Directiu' ? 'selected' : '' }}>Directiu</option>
            <option value="Administració" {{ old('role') == 'Administració' ? 'selected' : '' }}>Administració</option>
            <option value="Tècnic" {{ old('role') == 'Tècnic' ? 'selected' : '' }}>Tècnic</option>
        </select>

        <label for="id_employment_status" class="label">
            <span class="label-text">Estat de treball</span>
        </label>
        <select name="employment_status" id="id_employment_status" class="select select-bordered w-full">
            <option value=""></option>
            <option value="Actiu" {{ old('employment_status') == 'Actiu' ? 'selected' : '' }}>Actiu</option>
            <option value="Suplència" {{ old('employment_status') == 'Suplència' ? 'selected' : '' }}>Suplència</option>
            <option value="Baixa" {{ old('employment_status') == 'Baixa' ? 'selected' : '' }}>Baixa</option>
            <option value="No contractat" {{ old('employment_status') == 'No contractat' ? 'selected' : '' }}>No contractat</option>
        </select>

        <input type="text" name="phone" id="id_phone" placeholder="Telèfon" class="input input-bordered w-full" value="{{ old('phone') }}">
        <input type="email" name="email" id="id_email" placeholder="Correu electrònic" class="input input-bordered w-full" value="{{ old('email') }}" required>
        <input type="text" name="address" id="id_address" placeholder="Adreça" class="input input-bordered w-full" value="{{ old('address') }}">
        <input type="text" name="key_code" id="id_key_code" placeholder="Codi de clau" class="input input-bordered w-full" value="{{ old('key_code') }}">
        <textarea name="cvitae" id="id_cvitae" rows="4" placeholder="Currículum Vitae..." class="textarea textarea-bordered w-full">{{ old('cvitae') }}</textarea>

        <input type="text" name="user" id="id_user" placeholder="Nom d'usuari" class="input input-bordered w-full" value="{{ old('user') }}" autocomplete="off" required>
        <input type="password" name="password" id="id_password" placeholder="Contrasenya" class="input input-bordered w-full" autocomplete="new-password" required>

        <div class="flex gap-2 mt-4">
            <input type="reset" value="Reiniciar" class="btn flex-1">
            <input type="submit" value="Acceptar" class="btn btn-info flex-1">
        </div>
    </form>
</div>

@include('components.layout.mainToasts')
@endsection
