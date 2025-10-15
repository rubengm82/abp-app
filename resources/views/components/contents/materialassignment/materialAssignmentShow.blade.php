@extends('app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detalls de l'Assignació de Material</h1>
        <div class="flex gap-2">
            <a href="{{ route('materialassignments_list') }}" class="btn btn-sm btn-outline">Tornar a la llista</a>
            <a href="{{ route('materialassignment_edit', $materialAssignment) }}" class="btn btn-sm btn-warning">Editar</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Informació de l'assignació -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de l'Assignació</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold text-gray-600">ID:</label>
                        <p class="text-lg">{{ $materialAssignment->id }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Data d'assignació:</label>
                        <p class="text-lg">{{ $materialAssignment->assignment_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Assignat per:</label>
                        <p class="text-lg">
                            @if($materialAssignment->assignedBy)
                                {{ $materialAssignment->assignedBy->name }} {{ $materialAssignment->assignedBy->surname1 }}
                            @else
                                No especificat
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Information about the professional -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Professional</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold text-gray-600">Nom:</label>
                        <p class="text-lg">{{ $materialAssignment->professional->name }} {{ $materialAssignment->professional->surname1 }} {{ $materialAssignment->professional->surname2 }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">DNI:</label>
                        <p class="text-lg">{{ $materialAssignment->professional->dni }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Rol:</label>
                        <p class="text-lg">{{ $materialAssignment->professional->role }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned sizes -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Talles Assignades</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <label class="font-semibold text-gray-600">Samarreta:</label>
                    @if($materialAssignment->shirt_size)
                        <p class="text-2xl font-bold text-blue-600">{{ $materialAssignment->shirt_size }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold text-gray-600">Pantaló:</label>
                    @if($materialAssignment->pants_size)
                        <p class="text-2xl font-bold text-green-600">{{ $materialAssignment->pants_size }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold text-gray-600">Sabata:</label>
                    @if($materialAssignment->shoe_size)
                        <p class="text-2xl font-bold text-purple-600">{{ $materialAssignment->shoe_size }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- TODO: Revisar tema de documentos -->
    <!-- Observations and documents -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació Addicional</h2>
            <div class="space-y-4">
                <div>
                    <label class="font-semibold text-gray-600">Observacions:</label>
                    <p class="text-lg mt-2 break-words overflow-wrap-anywhere">{{ $materialAssignment->observations ?: 'No hi ha observacions' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Data de creació:</label>
                    <p class="text-lg">{{ $materialAssignment->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Última actualització:</label>
                    <p class="text-lg">{{ $materialAssignment->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Section -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-xl">Documents</h2>
                <button class="btn btn-sm btn-primary" onclick="document.getElementById('addDocumentModal').showModal()">
                    Pujar Document
                </button>
            </div>
            
            @if($materialAssignment->documents && $materialAssignment->documents->count() > 0)
                <div class="space-y-3">
                    @foreach($materialAssignment->documents->sortByDesc('created_at') as $document)
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-green-500">
                            <div class="flex justify-between items-center">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('materialassignment_document_download', $document) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                            {{ $document->original_name ?: 'Document sense nom' }}
                                        </a>
                                        <span class="text-sm text-gray-500">
                                            ({{ $document->file_size ? number_format($document->file_size / 1024, 2) . ' KB' : 'Mida desconeguda' }})
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        <strong>{{ $document->uploadedByProfessional->name ?? 'Usuari desconegut' }} {{ $document->uploadedByProfessional->surname1 ?? '' }}</strong>
                                        <span class="ml-2">{{ $document->created_at ? $document->created_at->format('d/m/Y H:i') : 'Data desconeguda' }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('materialassignment_document_delete', $document) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-error" onclick="return confirm('Estàs segur que vols eliminar aquest document?')">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">No hi ha documents per aquesta assignació de material.</p>
            @endif
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
            
            @if($materialAssignment->notes && $materialAssignment->notes->count() > 0)
                <div class="space-y-4">
                    @foreach($materialAssignment->notes->sortByDesc('created_at') as $note)
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500">
                            <div class="flex justify-between items-start mb-2">
                                <div class="text-sm text-gray-600">
                                    <strong>{{ $note->createdByProfessional->name ?? 'Usuari desconegut' }} {{ $note->createdByProfessional->surname1 ?? '' }}</strong>
                                    <span class="ml-2">{{ $note->created_at ? $note->created_at->format('d/m/Y H:i') : 'Data desconeguda' }}</span>
                                </div>
                                <div class="flex gap-2">
                                    <button class="btn btn-xs btn-info" onclick="openEditNoteModal({{ $note->id }}, '{{ addslashes($note->notes) }}')">
                                        Editar
                                    </button>
                                    <form action="{{ route('materialassignment_note_delete', $note) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-error" onclick="return confirm('Estàs segur que vols eliminar aquesta nota?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p class="text-gray-800 break-words whitespace-pre-wrap">{{ $note->notes }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">No hi ha notes per aquesta assignació de material.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal para añadir nota -->
<dialog id="addNoteModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Afegir Nova Nota</h3>
        <form action="{{ route('materialassignment_note_add', $materialAssignment) }}" method="POST">
            @csrf
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

<!-- Modal para editar nota -->
<dialog id="editNoteModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Editar Nota</h3>
        <form id="editNoteForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Nota:</span>
                </label>
                <textarea name="notes" id="editNoteText" class="textarea textarea-bordered w-full" rows="4" placeholder="Escriu la nota aquí..." required></textarea>
            </div>
            <div class="modal-action">
                <button type="button" class="btn" onclick="document.getElementById('editNoteModal').close()">Cancel·lar</button>
                <button type="submit" class="btn btn-primary">Guardar Canvis</button>
            </div>
        </form>
    </div>
</dialog>

<!-- Modal para pujar documents -->
<dialog id="addDocumentModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Pujar Document</h3>
        <form action="{{ route('materialassignment_document_add', $materialAssignment) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Seleccionar Document:</span>
                </label>
                <input type="file" name="document" class="file-input file-input-bordered w-full" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.txt" required>
                <div class="label">
                    <span class="label-text-alt">Formats suportats: PDF, DOC, DOCX, JPG, JPEG, PNG, TXT</span>
                </div>
            </div>
            <div class="modal-action">
                <button type="button" class="btn" onclick="this.closest('dialog').close()">Cancel·lar</button>
                <button type="submit" class="btn btn-primary">Pujar Document</button>
            </div>
        </form>
    </div>
</dialog>

<script>
function openEditNoteModal(noteId, noteText) {
    document.getElementById('editNoteText').value = noteText;
    document.getElementById('editNoteForm').action = `/materialassignment/notes/${noteId}`;
    document.getElementById('editNoteModal').showModal();
}
</script>

{{-- TOAST: SUCCESS MESSAGES --}}
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

@if (session('success_note_updated'))
    <div class="toast toast-end">
        <div class="alert alert-success">
            <span>{{ session('success_note_updated') }}</span>
        </div>
    </div>
@endif

@if (session('success_document_added'))
    <div class="toast toast-end">
        <div class="alert alert-success">
            <span>{{ session('success_document_added') }}</span>
        </div>
    </div>
@endif

@if (session('success_document_deleted'))
    <div class="toast toast-end">
        <div class="alert alert-success">
            <span>{{ session('success_document_deleted') }}</span>
        </div>
    </div>
@endif

@if (session('error_document_not_found'))
    <div class="toast toast-end">
        <div class="alert alert-error">
            <span>{{ session('error_document_not_found') }}</span>
        </div>
    </div>
@endif

@if (session('error_document_upload'))
    <div class="toast toast-end">
        <div class="alert alert-error">
            <span>{{ session('error_document_upload') }}</span>
        </div>
    </div>
@endif

@endsection
