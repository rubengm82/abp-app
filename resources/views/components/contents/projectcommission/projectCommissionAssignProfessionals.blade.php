@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Projectes' => route('projectcommissions_list'),
        'Projecte' => route('projectcommission_show', $projectCommission),
    ]"
    :current="'Assignar professionals'"
/>

<div class="max-w-6xl mx-auto bg-base-100 p-6 rounded shadow">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-base-content">{{ $projectCommission->name }}</h1>
    </div>

    <p class="text-gray-600 mb-6">Arrossega els professionals entre les llistes per assignar-los o desassignar-los del projecte.</p>

    <!-- DRAG AND DROP MANUAL -->
    <div class="card bg-base-100 shadow-xl p-6 select-none">
        <h3 class="text-xl font-bold mb-6">Assignació de Professionals</h3>

        <form method="POST" action="{{ route('projectcommission_update_professional_assignments', $projectCommission) }}" id="assignmentFormManual">
            @csrf

            <div class="flex gap-6 mt-4" id="dropZona">
                <!-- Unassigned List -->
                <div class="w-1/2">
                    <h4 class="text-lg font-semibold mb-3">No assignats</h4>
                    <ul id="unassigned-manual"
                    ondragover="event.preventDefault();"
                    ondrop="handleDrop(event, this);"
                    class="bg-base-200 rounded-lg shadow-md p-4 space-y-3 h-[500px] overflow-y-auto">
                        @foreach($unassignedProfessionals as $professional)
                            <li draggable="true"
                                id="professional-{{ $professional->id }}"
                                class="professional-item-manual p-3 bg-base-100 rounded-lg shadow cursor-move hover:bg-primary hover:text-white transition"
                                data-id="{{ $professional->id }}"
                                ondragstart="event.dataTransfer.setData('professional-id', this.id);">
                                {{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Assigned List -->
                <div class="w-1/2">
                    <h4 class="text-lg font-semibold mb-3">Assignats</h4>
                    <ul id="assigned-manual" class="bg-base-200 rounded-lg shadow-md p-4 space-y-3 h-[500px] overflow-y-auto"
                        ondragover="event.preventDefault();"
                        ondrop="handleDrop(event, this);">
                        @foreach($assignedProfessionals as $professional)
                            <li draggable="true"
                                id="professional-{{ $professional->id }}"
                                class="professional-item-manual p-3 bg-base-100 rounded-lg shadow cursor-move hover:bg-secondary hover:text-white transition"
                                data-id="{{ $professional->id }}"
                                ondragstart="event.dataTransfer.setData('professional-id', this.id);">
                                {{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('projectcommission_show', $projectCommission) }}" class="btn btn-outline">Cancel·lar</a>
                <button type="submit" class="btn btn-info">Confirmar canvis</button>
            </div>
        </form>
    </div>
    <!-- END DRAG AND DROP -->

</div>

@include('components.partials.mainToasts')

<script src="{{ asset('js/components/partials/drag_drop_id_assignor.js') }}"></script>

@endsection

