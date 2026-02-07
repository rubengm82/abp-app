@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => route('professionals_list'),
        'Seguiment' => route('seguiment_list'),
    ]"
    :current="$professional->name . ' ' . $professional->surname1 . ' ' . $professional->surname2"
    />

<div class="max-w-4xl mx-auto bg-base-200 text-base-content p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-base-content">Seguiment · {{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}</h1>
        <a href="{{ route('professional_show', $professional) }}" class="btn btn-sm btn-outline">Fitxa del professional</a>
    </div>

    <x-partials.notes-section
        :items="$professional->notes"
        title="Seguiment"
        addAction="{{ route('professional_note_add', $professional) }}"
        deleteRoute="professional_note_delete"
        :editRoute="'professional_note_update'"
        createdByField="createdByProfessional"
    />
</div>

@include('components.partials.mainToasts')
@endsection
