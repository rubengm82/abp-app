@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Afegir projecte/comissió</h1>

<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <form action="{{ route('projectcommission_add') }}" method="post" class="space-y-4">
        @csrf

        <!-- Campos del formulario -->
        <input type="text" name="name" id="id_name" placeholder="Nom/Títol del projecte/comissió" class="input input-bordered w-full" required>
        
        <select name="type" id="id_type" class="select select-bordered w-full" required>
            <option value="">Selecciona el tipus</option>
            <option value="Projecte">Projecte</option>
            <option value="Comissió">Comissió</option>
        </select>

        <!-- TODO: Revisar si es necesario el "título" para especificar el uso de los campos -->
        <!-- TODO: Revisar el formato de fecha que se está utilizando! -->

        <!-- <input type="date" name="start_date" id="id_start_date" class="input input-bordered w-full" placeholder="Data d'inici">
        <input type="date" name="estimated_end_date" id="id_estimated_end_date" class="input input-bordered w-full" placeholder="Data estimada de finalització"> -->

        <label for="id_start_date" class="label">
            <span class="label-text">Data d'inici</span>
        </label>
        <input type="date" name="start_date" id="id_start_date" class="input input-bordered w-full" value="{{ date('Y-m-d') }}">

        <label for="id_estimated_end_date" class="label">
            <span class="label-text">Data estimada de finalització</span>
        </label>
        <input type="date" name="estimated_end_date" id="id_estimated_end_date" class="input input-bordered w-full">

        <!-- <input type="integer" name="responsible_professional_id" id="id_responsible_professional_id" class="input input-bordered w-full" placeholder="Professional responsable" required> -->
        <select name="responsible_professional_id" id="id_responsible_professional_id" class="select select-bordered w-full">
            <option value="">Professional responsable</option>
            <!-- Esto es canela -->
            @foreach($professionals as $professional)
                <option value="{{ $professional->id }}">{{ $professional->name }} {{ $professional->surname1 }}</option>
            @endforeach
        </select>

        <textarea name="description" id="id_description" placeholder="Descripció del projecte/comissió" class="textarea textarea-bordered w-full" rows="4"></textarea>
        
        <!-- <textarea name="notes" id="id_notes" placeholder="Notes addicionals (Temporal)" class="textarea textarea-bordered w-full" rows="3"></textarea> -->
        
        <div class="flex gap-2">
            <input type="reset" value="Reset" class="btn flex-1">
            <input type="submit" value="Acceptar" class="btn btn-info flex-1">
        </div>
    </form>

    {{-- TOAST: SUCCESS ADDED --}}
    @if (session('success_added'))
        <div class="toast toast-end">
            <div class="alert alert-success">
                <span>{{ session('success_added') }}</span>
            </div>
        </div>
    @endif
</div>
@endsection
