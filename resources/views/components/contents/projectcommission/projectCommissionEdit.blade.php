@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Editar projecte/comissió</h1>

<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <form action="{{ route('projectcommission_update', $projectCommission) }}" method="post" class="space-y-4">
        @csrf

        <input type="text" name="name" id="id_name" placeholder="Nom/Títol del projecte/comissió" class="input input-bordered w-full" value="{{ $projectCommission->name }}" required>
        
        <select name="type" id="id_type" class="select select-bordered w-full" required>
            <option value="">Selecciona el tipus</option>
            <option value="Projecte" {{ $projectCommission->type == 'Projecte' ? 'selected' : '' }}>Projecte</option>
            <option value="Comissió" {{ $projectCommission->type == 'Comissió' ? 'selected' : '' }}>Comissió</option>
        </select>

        <input type="date" name="start_date" id="id_start_date" class="input input-bordered w-full" value="{{ $projectCommission->start_date }}">
        
        <input type="date" name="estimated_end_date" id="id_estimated_end_date" class="input input-bordered w-full" value="{{ $projectCommission->estimated_end_date }}">

        <select name="responsible_professional_id" id="id_responsible_professional_id" class="select select-bordered w-full">
            <option value="">Professional responsable</option>
            @foreach($professionals as $professional)
                <option value="{{ $professional->id }}" {{ $projectCommission->responsible_professional_id == $professional->id ? 'selected' : '' }}>
                    {{ $professional->name }} {{ $professional->surname1 }}
                </option>
            @endforeach
        </select>

        <textarea name="description" id="id_description" placeholder="Descripció del projecte/comissió" class="textarea textarea-bordered w-full" rows="4">{{ $projectCommission->description }}</textarea>
        
        <!-- <textarea name="notes" id="id_notes" placeholder="Notes addicionals" class="textarea textarea-bordered w-full" rows="3">{{ $projectCommission->notes }}</textarea> -->
        
        <div class="flex gap-2">
            <a href="{{ route('projectcommission_show', $projectCommission) }}" class="btn btn-outline flex-1">Cancel·lar</a>
            <input type="submit" value="Actualitzar" class="btn btn-info flex-1">
        </div>
    </form>

</div>

@include('components.layout.mainToasts')
@endsection
