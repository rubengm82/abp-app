@extends('app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}</h1>
        <div class="flex gap-2">
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline">Tornar</a>
            <a href="{{ route('professional_edit', $professional) }}" class="btn btn-sm btn-info">Editar</a>
            @if($professional->status == 1)
                <a href="{{ route('professional_desactivate', $professional) }}" class="btn btn-sm btn-error">Desactivar</a>
            @else
                <a href="{{ route('professional_activate', $professional) }}" class="btn btn-sm btn-success">Activar</a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Personal information -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació personal</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold text-gray-600">Nom complet:</label>
                        <p class="text-lg">{{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">DNI:</label>
                        <p class="text-lg">{{ $professional->dni }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Rol:</label>
                        <p class="text-lg">{{ $professional->role ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Estat laboral:</label>
                        <p class="text-lg">
                            <span class="badge {{ $professional->employment_status === 'Actiu' ? 'badge-success' : 'badge-warning' }}">
                                {{ $professional->employment_status ?: 'No especificat' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact information -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de contacte</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold text-gray-600">Telèfon:</label>
                        <p class="text-lg">{{ $professional->phone ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Email:</label>
                        <p class="text-lg">{{ $professional->email ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Adreça:</label>
                        <p class="text-lg">{{ $professional->address ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Codi de clau:</label>
                        <p class="text-lg">{{ $professional->key_code ?: 'No especificat' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Curriculum Vitae -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Currículum Vitae</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-lg break-words whitespace-pre-wrap">{{ $professional->cvitae ?: 'No hi ha currículum disponible' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional information -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació addicional</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-semibold text-gray-600">ID:</label>
                    <p class="text-lg">{{ $professional->id }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Usuari de login:</label>
                    <p class="text-lg">{{ $professional->user ?: 'No especificat' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Estat:</label>
                    <p class="text-lg">
                        <span class="badge {{ $professional->status == 1 ? 'badge-success' : 'badge-error' }}">
                            {{ $professional->status == 1 ? 'Actiu' : 'Inactiu' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Assignacions de material -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Assignacions de Material</h2>
            @php
                $shirtSize = \App\Models\MaterialAssignment::getLatestShirtSize($professional->id);
                $pantsSize = \App\Models\MaterialAssignment::getLatestPantsSize($professional->id);
                $shoeSize = \App\Models\MaterialAssignment::getLatestShoeSize($professional->id);
            @endphp
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <label class="font-semibold text-gray-600">Samarreta:</label>
                    @if($shirtSize)
                        <p class="text-2xl font-bold text-blue-600">{{ $shirtSize }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold text-gray-600">Pantaló:</label>
                    @if($pantsSize)
                        <p class="text-2xl font-bold text-green-600">{{ $pantsSize }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold text-gray-600">Sabata:</label>
                    @if($shoeSize)
                        <p class="text-2xl font-bold text-purple-600">{{ $shoeSize }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
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
            
            @if($professional->documents && $professional->documents->count() > 0)
                <div class="space-y-3">
                    @foreach($professional->documents->sortByDesc('created_at') as $document)
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-green-500">
                            <div class="flex justify-between items-center">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('professional_document_download', $document) }}" class="text-blue-600 hover:text-blue-800 font-medium">
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
                                <form action="{{ route('professional_document_delete', $document) }}" method="POST" class="inline">
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
                <p class="text-gray-500 italic">No hi ha documents per aquest professional.</p>
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
            
            @if($professional->notes && $professional->notes->count() > 0)
                <div class="space-y-4">
                    @foreach($professional->notes->sortByDesc('created_at') as $note)
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
                                    <form action="{{ route('professional_note_delete', $note) }}" method="POST" class="inline">
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
                <p class="text-gray-500 italic">No hi ha notes per aquest professional.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal to add note -->
<dialog id="addNoteModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Afegir Nova Nota</h3>
        <form action="{{ route('professional_note_add', $professional) }}" method="POST">
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
        <form action="{{ route('professional_document_add', $professional) }}" method="POST" enctype="multipart/form-data">
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
    document.getElementById('editNoteForm').action = `/professional/notes/${noteId}`;
    document.getElementById('editNoteModal').showModal();
}
</script>

@include('components.layout.mainToasts')

@endsection