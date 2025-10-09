@extends('app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $projectCommission->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('projectcommissions_list') }}" class="btn btn-sm btn-outline">Tornar a la llista</a>
            <a href="{{ route('projectcommission_edit', $projectCommission) }}" class="btn btn-sm btn-info">Editar</a>
            <a href="{{ route('projectcommission_desactivate', $projectCommission) }}" class="btn btn-sm btn-error">Desactivar</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació bàsica</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold text-gray-600">Tipus:</label>
                        <p class="text-lg">{{ $projectCommission->type }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Data d'inici:</label>
                        <p class="text-lg">{{ $projectCommission->start_date ? : 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Data estimada de finalització:</label>
                        <p class="text-lg">{{ $projectCommission->estimated_end_date ? : 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Professional responsable:</label>
                        <p class="text-lg">
                            @if($projectCommission->responsibleProfessional)
                                {{ $projectCommission->responsibleProfessional->name }} {{ $projectCommission->responsibleProfessional->surname1 }}
                            @else
                                No assignat
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Descripció</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-lg mt-2">{{ $projectCommission->description ?: 'No hi ha descripció disponible' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aditional Information -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació addicional</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-semibold text-gray-600">ID:</label>
                    <p class="text-lg">{{ $projectCommission->id }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Data de creació:</label>
                    <p class="text-lg">{{ $projectCommission->created_at ? : 'No especificada' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Última actualització:</label>
                    <p class="text-lg">{{ $projectCommission->updated_at ? : 'No especificada' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Section -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-xl">Notes</h2>
                <button class="btn btn-sm btn-primary" onclick="document.getElementById('addNoteModal').showModal()">
                    Afegir Nota
                </button>
            </div>
            
            @if($projectCommission->projectNotes->count() > 0)
                <div class="space-y-4">
                    @foreach($projectCommission->projectNotes as $note)
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500">
                            <div class="flex justify-between items-start mb-2">
                                <div class="text-sm text-gray-600">
                                    <strong>{{ $note->professional->name }} {{ $note->professional->surname1 }}</strong>
                                    <span class="ml-2">{{ $note->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <form action="{{ route('projectcommission_note_delete', $note) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-error" onclick="return confirm('Estàs segur que vols eliminar aquesta nota?')">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                            <p class="text-gray-800">{{ $note->notes }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">No hi ha notes per aquest projecte/comissió.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal para añadir nota -->
<dialog id="addNoteModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Afegir Nova Nota</h3>
        <form action="{{ route('projectcommission_note_add', $projectCommission) }}" method="POST">
            @csrf
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Professional:</span>
                </label>
                <select name="professional_id" class="select select-bordered w-full">
                    <!-- TODO: EDitar para que recoja el nombre del usuario logueado -->
                    <option value="">Selecciona un professional</option>
                    @foreach(\App\Models\Professional::where('status', 1)->get() as $professional)
                        <option value="{{ $professional->id }}">{{ $professional->name }} {{ $professional->surname1 }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Nota:</span>
                </label>
                <textarea name="notes" class="textarea textarea-bordered w-full" rows="4" placeholder="Escriu la nota aquí..." required></textarea>
            </div>
            <div class="modal-action">
                <button type="button" class="btn" onclick="document.getElementById('addNoteModal').close()">Cancel·lar</button>
                <button type="submit" class="btn btn-primary">Afegir Nota</button>
            </div>
        </form>
    </div>
</dialog>

{{-- TOAST: SUCCESS MESSAGES --}}
@if (session('success_desactivated'))
    <div class="toast toast-end">
        <div class="alert alert-success">
            <span>{{ session('success_desactivated') }}</span>
        </div>
    </div>
@endif

@if (session('success_note_added'))
    <div class="toast toast-end">
        <div class="alert alert-success">
            <span>{{ session('success_note_added') }}</span>
        </div>
    </div>
@endif

@if (session('success_note_deleted'))
    <div class="toast toast-end">
        <div class="alert alert-success">
            <span>{{ session('success_note_deleted') }}</span>
        </div>
    </div>
@endif

@endsection
