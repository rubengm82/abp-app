@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => route('professionals_list'),
    ]"
    :current="'Afegir Professional'"
    />
<div class="max-w-4xl mx-auto bg-base-200 p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <h1 class="text-3xl font-bold text-base-content mb-6 text-center">Afegir professional</h1>
    
    <!-- Show validation errors -->
    @if ($errors->any())
        <div class="alert alert-error mb-6">
            <div>
                <div>
                    <h3 class="font-bold text-base-content mb-1">Hi ha errors en el formulari:</h3>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('professional_add') }}" method="post" class="space-y-6">
        @csrf

        <!-- Personal Information -->
        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació Personal</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Nom *</span>
                        </label>
                        <input type="text" name="name" id="id_name" placeholder="Ex: Joan" class="input input-bordered w-full" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Primer cognom *</span>
                        </label>
                        <input type="text" name="surname1" id="id_surname1" placeholder="Ex: García" class="input input-bordered w-full" value="{{ old('surname1') }}" required>
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Segon cognom</span>
                        </label>
                        <input type="text" name="surname2" id="id_surname2" placeholder="Ex: López" class="input input-bordered w-full" value="{{ old('surname2') }}">
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">DNI *</span>
                        </label>
                        <input type="text" name="dni" id="id_dni" placeholder="Ex: 12345678A" class="input input-bordered w-full" value="{{ old('dni') }}" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Information -->
        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació Professional</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Rol del professional</span>
                        </label>
                        <select name="role" id="id_role" class="select select-bordered w-full">
                            <option value="">Selecciona un rol</option>
                            <option value="Directiu" {{ old('role') == 'Directiu' ? 'selected' : '' }}>Directiu</option>
                            <option value="Administració" {{ old('role') == 'Administració' ? 'selected' : '' }}>Administració</option>
                            <option value="Tècnic" {{ old('role') == 'Tècnic' ? 'selected' : '' }}>Tècnic</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Estat de treball</span>
                        </label>
                        <select name="employment_status" id="id_employment_status" class="select select-bordered w-full">
                            <option value="">Selecciona estat</option>
                            <option value="Actiu" {{ old('employment_status') == 'Actiu' ? 'selected' : '' }}>Actiu</option>
                            <option value="Suplència" {{ old('employment_status') == 'Suplència' ? 'selected' : '' }}>Suplència</option>
                            <option value="Baixa" {{ old('employment_status') == 'Baixa' ? 'selected' : '' }}>Baixa</option>
                            <option value="No contractat" {{ old('employment_status') == 'No contractat' ? 'selected' : '' }}>No contractat</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació de Contacte</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Telèfon</span>
                        </label>
                        <input type="text" name="phone" id="id_phone" placeholder="Ex: 612 345 678" class="input input-bordered w-full" value="{{ old('phone') }}">
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Correu electrònic *</span>
                        </label>
                        <input type="email" name="email" id="id_email" placeholder="Ex: joan@empresa.com" class="input input-bordered w-full" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-control md:col-span-2">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Adreça</span>
                        </label>
                        <input type="text" name="address" id="id_address" placeholder="Ex: Carrer Major, 123, Barcelona" class="input input-bordered w-full" value="{{ old('address') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació Adicional</h2>
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Taquilla</span>
                        </label>
                        <input type="text" name="locker_num" id="id_locker_num" placeholder="Ex: 15" class="input input-bordered w-full" value="{{ old('locker_num') }}">
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Codi de clau</span>
                        </label>
                        <input type="text" name="key_code" id="id_key_code" placeholder="Ex: ABC123" class="input input-bordered w-full" value="{{ old('key_code') }}">
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Currículum Vitae</span>
                        </label>
                        <textarea name="cvitae" id="id_cvitae" rows="4" placeholder="Descriu l'experiència professional, formació i habilitats..." class="textarea textarea-bordered w-full">{{ old('cvitae') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Access Credentials -->
        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Credencials d'Accés</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Nom d'usuari *</span>
                        </label>
                        <input type="text" name="user" id="id_user" placeholder="Ex: joan.garcia" class="input input-bordered w-full" value="{{ old('user') }}" autocomplete="off" required>
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Contrasenya *</span>
                        </label>
                        <input type="password" name="password" id="id_password" placeholder="Mínim 4 caràcters" class="input input-bordered w-full" autocomplete="new-password" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('professional_form') }}" class="btn btn-outline">Netejar</a>
            <input type="submit" value="Crear Professional" class="btn btn-info">
        </div>
    </form>
</div>

@include('components.partials.mainToasts')
@endsection
