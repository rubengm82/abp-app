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

    <form action="{{ route('professional_add') }}" method="post" class="space-y-6" enctype="multipart/form-data">
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

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Data de naixement</span>
                        </label>
                        <input type="date" name="birth_date" id="id_birth_date" class="input input-bordered w-full" value="{{ old('birth_date') }}">
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Data de contractació (Antiguitat)</span>
                        </label>
                        <input type="date" name="first_hire_date" id="id_first_hire_date" class="input input-bordered w-full" value="{{ old('first_hire_date') }}">
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Gènere</span>
                        </label>
                        <select name="gender" id="id_gender" class="select select-bordered w-full">
                            <option value="">Selecciona gènere</option>
                            <option value="Home" {{ old('gender') == 'Home' ? 'selected' : '' }}>Home</option>
                            <option value="Dona" {{ old('gender') == 'Dona' ? 'selected' : '' }}>Dona</option>
                            <option value="Altre" {{ old('gender') == 'Altre' ? 'selected' : '' }}>Altre</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Nivell de formació</span>
                        </label>
                        <input type="text" name="education_level" id="id_education_level" placeholder="Ex: Universitat, FP, etc." class="input input-bordered w-full" value="{{ old('education_level') }}">
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
                            <span class="label-text">Permisos</span>
                        </label>
                        <select name="permissions" id="id_permissions" class="select select-bordered w-full">
                            <option value="">Selecciona permisos</option>
                            <option value="Direcció" {{ old('permissions') == 'Direcció' ? 'selected' : '' }}>Direcció</option>
                            <option value="Administració" {{ old('permissions') == 'Administració' ? 'selected' : '' }}>Administració</option>
                            <option value="Tècnic" {{ old('permissions') == 'Tècnic' ? 'selected' : '' }}>Tècnic</option>
                            <option value="Gerència" {{ old('permissions') == 'Gerència' ? 'selected' : '' }}>Gerència</option>
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Rol</span>
                        </label>
                        <select name="role" id="id_role" class="select select-bordered w-full">
                            <option value="">Selecciona un rol</option>
                            <option value="ATE" {{ old('role') == 'ATE' ? 'selected' : '' }}>ATE</option>
                            <option value="ATE-RT" {{ old('role') == 'ATE-RT' ? 'selected' : '' }}>ATE-RT</option>
                            <option value="Infermeria" {{ old('role') == 'Infermeria' ? 'selected' : '' }}>Infermeria</option>
                            <option value="Metge" {{ old('role') == 'Metge' ? 'selected' : '' }}>Metge</option>
                            <option value="Recepció" {{ old('role') == 'Recepció' ? 'selected' : '' }}>Recepció</option>
                            <option value="Administració" {{ old('role') == 'Administració' ? 'selected' : '' }}>Administració</option>
                            <option value="Treball Social" {{ old('role') == 'Treball Social' ? 'selected' : '' }}>Treball Social</option>
                            <option value="Pedagogia/Psicologia" {{ old('role') == 'Pedagogia/Psicologia' ? 'selected' : '' }}>Pedagogia/Psicologia</option>
                            <option value="Fisioteràpia" {{ old('role') == 'Fisioteràpia' ? 'selected' : '' }}>Fisioteràpia</option>
                            <option value="Direcció" {{ old('role') == 'Direcció' ? 'selected' : '' }}>Direcció</option>
                            <option value="Altres" {{ old('role') == 'Altres' ? 'selected' : '' }}>Altres</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Estat de treball</span>
                        </label>
                        <select name="employment_status" id="id_employment_status" class="select select-bordered w-full">
                            <option value="">Selecciona estat</option>
                            <option value="Fixe" {{ old('employment_status') == 'Fixe' ? 'selected' : '' }}>Fixe</option>
                            <option value="Eventual" {{ old('employment_status') == 'Eventual' ? 'selected' : '' }}>Eventual</option>
                            <option value="Suplent habitual" {{ old('employment_status') == 'Suplent habitual' ? 'selected' : '' }}>Suplent habitual</option>
                            <option value="Baixa definitiva" {{ old('employment_status') == 'Baixa definitiva' ? 'selected' : '' }}>Baixa definitiva</option>
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
                            <span class="label-text">Telèfon *</span>
                        </label>
                        <input type="text" name="phone" id="id_phone" placeholder="Ex: 612 345 678" class="input input-bordered w-full" value="{{ old('phone') }}" required>
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
                            <span class="label-text">Currículum Vitae (text)</span>
                        </label>
                        <textarea name="cvitae" id="id_cvitae" rows="4" placeholder="Descriu l'experiència professional, formació i habilitats..." class="textarea textarea-bordered w-full">{{ old('cvitae') }}</textarea>
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Currículum Vitae (fitxer)</span>
                        </label>
                        <input type="file" name="cv_file" id="id_cv_file" class="file-input file-input-bordered w-full" accept=".pdf,.doc,.docx">
                        <p class="text-xs text-base-content/60 mt-1">Màxim 10 MB. Opcional.</p>
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
                            <span class="label-text">Nom d'usuari</span>
                        </label>
                        <input type="text" name="user" id="id_user" placeholder="Ex: joan.garcia" class="input input-bordered w-full" value="{{ old('user') }}" autocomplete="off">
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Contrasenya</span>
                        </label>
                        <input type="password" name="password" id="id_password" placeholder="Mínim 4 caràcters (opcional)" class="input input-bordered w-full" autocomplete="new-password">
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
