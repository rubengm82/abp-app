@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Contactes Externs' => route('externalcontacts_list'),
        'Detalls' => route('externalcontact_show', $externalContact->id),
    ]"
    :current="'Editar'"
    />
<div class="max-w-4xl mx-auto bg-base-200 p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <h1 class="text-3xl font-bold text-base-content mb-6 text-center">Editar contacte extern</h1>
    
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

    <form action="{{ route('externalcontact_update', $externalContact) }}" method="post" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació Bàsica</h2>
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Tipus *</span>
                        </label>
                        <select name="external_contact_type" id="id_external_contact_type" class="select select-bordered w-full" required>
                            <option value="">Selecciona el tipus</option>
                            <option value="Assistencials" {{ old('external_contact_type', $externalContact->external_contact_type) == 'Assistencials' ? 'selected' : '' }}>Assistencials</option>
                            <option value="Servei General" {{ old('external_contact_type', $externalContact->external_contact_type) == 'Servei General' ? 'selected' : '' }}>Servei General</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Motiu / Servei</span>
                        </label>
                        <input type="text" name="service_reason" id="id_service_reason" placeholder="Ex: Manteniment, Neteja..." class="input input-bordered w-full" value="{{ old('service_reason', $externalContact->service_reason) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Company Information -->
        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació de l'Empresa</h2>
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Empresa *</span>
                        </label>
                        <input type="text" name="company" id="id_company" placeholder="Nom de l'empresa" class="input input-bordered w-full" value="{{ old('company', $externalContact->company) }}" required>
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Departament</span>
                        </label>
                        <input type="text" name="department" id="id_department" placeholder="Departament" class="input input-bordered w-full" value="{{ old('department', $externalContact->department) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Person Information -->
        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació del Responsable</h2>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label font-bold text-base-content mb-1">
                                <span class="label-text">Nom *</span>
                            </label>
                            <input type="text" name="name" id="id_name" placeholder="Nom del responsable" class="input input-bordered w-full" value="{{ old('name', $externalContact->name) }}" required>
                        </div>

                        <div class="form-control">
                            <label class="label font-bold text-base-content mb-1">
                                <span class="label-text">Cognom</span>
                            </label>
                            <input type="text" name="surname" id="id_surname" placeholder="Cognom del responsable" class="input input-bordered w-full" value="{{ old('surname', $externalContact->surname) }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label font-bold text-base-content mb-1">
                                <span class="label-text">Telèfon</span>
                            </label>
                            <input type="text" name="phone" id="id_phone" placeholder="Telèfon de contacte" class="input input-bordered w-full" value="{{ old('phone', $externalContact->phone) }}">
                        </div>

                        <div class="form-control">
                            <label class="label font-bold text-base-content mb-1">
                                <span class="label-text">Correu</span>
                            </label>
                            <input type="email" name="email" id="id_email" placeholder="Correu electrònic" class="input input-bordered w-full" value="{{ old('email', $externalContact->email) }}">
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Enllaç</span>
                        </label>
                        <input type="url" name="link" id="id_link" placeholder="https://..." class="input input-bordered w-full" value="{{ old('link', $externalContact->link) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació Addicional</h2>
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Observacions</span>
                        </label>
                        <textarea name="observations" id="id_observations" placeholder="Observacions addicionals..." class="textarea textarea-bordered w-full" rows="4">{{ old('observations', $externalContact->observations) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('externalcontacts_list') }}" class="btn btn-outline">Cancel·lar</a>
            <input type="submit" value="Actualitzar Contacte Extern" class="btn btn-info">
        </div>
    </form>
</div>

@include('components.partials.mainToasts')
@endsection

