@extends('app')

@section('content')
<div class="max-w-4xl mx-auto bg-base-100 text-base-content p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Detalls de l'Assignació de Material</h1>
        <div class="flex gap-2">
            <a href="{{ route('materialassignment_edit', $materialAssignment) }}" class="btn btn-sm btn-info">Editar</a>
            <x-partials.modal id="deleteAssignment{{ $materialAssignment->id }}" msj="Estàs segur que vols eliminar aquesta assignació?" btnText="Eliminar" class="btn-sm btn-error">
                <form action="{{ route('materialassignment_delete', $materialAssignment) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-error">Acceptar</button>
                </form>
            </x-partials.modal>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Assignment information -->
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de l'Assignació</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">ID:</label>
                        <p>{{ $materialAssignment->id }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Data d'assignació:</label>
                        <p>{{ $materialAssignment->assignment_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Assignat per:</label>
                        <p>
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
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Professional</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Nom:</label>
                        <p>{{ $materialAssignment->professional->name }} {{ $materialAssignment->professional->surname1 }} {{ $materialAssignment->professional->surname2 }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">DNI:</label>
                        <p>{{ $materialAssignment->professional->dni }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Rol:</label>
                        <p>{{ $materialAssignment->professional->role }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned sizes -->
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Talles Assignades</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <label class="font-semibold">Samarreta:</label>
                    @if($materialAssignment->shirt_size)
                        <p class="text-2xl font-bold text-blue-600">{{ $materialAssignment->shirt_size }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold">Pantaló:</label>
                    @if($materialAssignment->pants_size)
                        <p class="text-2xl font-bold text-green-600">{{ $materialAssignment->pants_size }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold">Sabata:</label>
                    @if($materialAssignment->shoe_size)
                        <p class="text-2xl font-bold text-purple-600">{{ $materialAssignment->shoe_size }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Observations and documents -->
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació Addicional</h2>
            <div class="space-y-4">
                <div>
                    <label class="font-semibold">Observacions:</label>
                    <p class="mt-2 break-words overflow-wrap-anywhere">{{ $materialAssignment->observations ?: 'No hi ha observacions' }}</p>
                </div>
                <div>
                    <label class="font-semibold">Data de creació:</label>
                    <p>{{ $materialAssignment->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="font-semibold">Última actualització:</label>
                    <p>{{ $materialAssignment->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Section -->
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-xl">Documents</h2>
                <button class="btn btn-sm btn-primary" onclick="document.getElementById('addDocumentModal').showModal()">Pujar Document</button>
            </div>

            @if($materialAssignment->documents && $materialAssignment->documents->count() > 0)
                <div class="space-y-3">
                    @foreach($materialAssignment->documents->sortByDesc('created_at') as $document)
                        <div class="bg-base-200 p-4 rounded-lg border-l-4 border-green-500">
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
                                <x-partials.modal id="deleteDocument{{ $document->id }}" msj="Estàs segur que vols eliminar aquest document?" btnText="Eliminar" class="btn-xs btn-error">
                                    <form action="{{ route('materialassignment_document_delete', $document) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-error">Acceptar</button>
                                    </form>
                                </x-partials.modal>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="italic text-gray-500">No hi ha documents per aquesta assignació de material.</p>
            @endif
        </div>
    </div>

    <!-- Notes Section -->
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-xl">Notes</h2>
                <button class="btn btn-sm btn-primary" onclick="document.getElementById('addNoteModal').showModal()">Afegir Nota</button>
            </div>

            @if($materialAssignment->notes && $materialAssignment->notes->count() > 0)
                <div class="space-y-4">
                    @foreach($materialAssignment->notes->sortByDesc('created_at') as $note)
                        <div class="bg-base-200 p-4 rounded-lg border-l-4 border-blue-500">
                            <div class="flex justify-between items-start mb-2">
                                <div class="text-sm text-base-content">
                                    <strong>{{ $note->createdByProfessional->name ?? 'Usuari desconegut' }} {{ $note->createdByProfessional->surname1 ?? '' }}</strong>
                                    <span class="ml-2">{{ $note->created_at ? $note->created_at->format('d/m/Y H:i') : 'Data desconeguda' }}</span>
                                </div>
                                <div class="flex gap-2">
                                    <button class="btn btn-xs btn-info" data-note-id="{{ $note->id }}" data-note-content="{{ $note->notes }}" onclick="openEditNoteModal(this.dataset.noteId, this.dataset.noteContent)">Editar</button>
                                    <x-partials.modal id="deleteNote{{ $note->id }}" msj="Estàs segur que vols eliminar aquesta nota?" btnText="Eliminar" class="btn-xs btn-error">
                                        <form action="{{ route('materialassignment_note_delete', $note) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error">Acceptar</button>
                                        </form>
                                    </x-partials.modal>
                                </div>
                            </div>
                            <p class="break-words whitespace-pre-wrap text-base-content">{{ $note->notes }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="italic text-gray-500">No hi ha notes per aquesta assignació de material.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modals -->
<dialog id="addNoteModal" class="modal">
    <div class="modal-box bg-base-100 text-base-content">
        <h3 class="font-bold text-lg mb-4">Afegir Nova Nota</h3>
        <form action="{{ route('materialassignment_note_add', $materialAssignment) }}" method="POST">
            @csrf
            <div class="form-control mb-4">
                <label class="label"><span class="label-text">Nota:</span></label>
                <textarea name="notes" class="textarea textarea-bordered w-full bg-base-100 text-base-content" rows="4" placeholder="Escriu la nota aquí..." required></textarea>
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-sm" onclick="document.getElementById('addNoteModal').close()">Cancel·lar</button>
                <button type="submit" class="btn btn-sm btn-info">Afegir Nota</button>
            </div>
        </form>
    </div>
</dialog>

<dialog id="editNoteModal" class="modal">
    <div class="modal-box bg-base-100 text-base-content">
        <h3 class="font-bold text-lg mb-4">Editar Nota</h3>
        <form id="editNoteForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-control mb-4">
                <label class="label"><span class="label-text">Nota:</span></label>
                <textarea name="notes" id="editNoteText" class="textarea textarea-bordered w-full bg-base-100 text-base-content" rows="4" placeholder="Escriu la nota aquí..." required></textarea>
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-sm" onclick="document.getElementById('editNoteModal').close()">Cancel·lar</button>
                <button type="submit" class="btn btn-sm btn-info">Desar Canvis</button>
            </div>
        </form>
    </div>
</dialog>

<dialog id="addDocumentModal" class="modal">
    <div class="modal-box bg-base-100 text-base-content">
        <h3 class="font-bold text-lg mb-4">Pujar Document</h3>
        <form action="{{ route('materialassignment_document_add', $materialAssignment) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-control mb-4">
                <label class="label"><span class="label-text">Seleccionar Document:</span></label>
                <input type="file" name="document" class="file-input file-input-bordered w-full bg-base-100 text-base-content" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.txt" required>
                <div class="label"><span class="label-text-alt">Formats suportats: PDF, DOC, DOCX, JPG, JPEG, PNG, TXT</span></div>
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-sm" onclick="this.closest('dialog').close()">Cancel·lar</button>
                <button type="submit" class="btn btn-sm btn-info">Pujar Document</button>
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

@include('components.layout.mainToasts')
@endsection
