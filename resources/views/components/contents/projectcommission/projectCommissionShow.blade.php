@extends('app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $projectCommission->name }}</h1>
        <div class="flex gap-2">
            @if($projectCommission->status == 'Actiu')
                <a href="{{ route('projectcommission_edit', $projectCommission) }}" class="btn btn-sm btn-info">Editar</a>
            @endif
            @if($projectCommission->status == 'Actiu')
                <x-partials.modal id="desactivateProjectCommission{{ $projectCommission->id }}" msj="Estàs segur que vols desactivar aquesta comissió?" btnText="Desactivar" class="btn-sm btn-error">
                    <a href="{{ route('projectcommission_desactivate', $projectCommission) }}" class="btn btn-sm btn-error">
                        Acceptar
                    </a>
                </x-partials.modal>
            @else
                <a href="{{ route('projectcommission_activate', $projectCommission) }}" class="btn btn-sm btn-success">Activar</a>
            @endif
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
                                <a href="{{ route('professional_show', $projectCommission->responsibleProfessional->id) }}" 
                                   class="text-primary font-semibold hover:text-orange-600 transition-all duration-200">
                                    {{ $projectCommission->responsibleProfessional->name }} {{ $projectCommission->responsibleProfessional->surname1 }}
                                </a>
                            @else
                                No assignat
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Centre:</label>
                        <p class="text-lg">
                            @if($projectCommission->responsibleProfessional && $projectCommission->responsibleProfessional->center)
                                <a href="{{ route('center_show', $projectCommission->responsibleProfessional->center->id) }}" 
                                   class="text-primary font-semibold hover:text-orange-600 transition-all duration-200">
                                    {{ $projectCommission->responsibleProfessional->center->name }}
                                </a>
                            @else
                                <span class="text-gray-400">No assignat</span>
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
                        <p class="text-lg mt-2 break-words overflow-wrap-anywhere">{{ $projectCommission->description ?: 'No hi ha descripció disponible' }}</p>
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

    <!-- Files Section -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-xl">Arxius</h2>
                <button class="btn btn-sm btn-primary" onclick="document.getElementById('addFileModal').showModal()">
                    Pujar Arxius
                </button>
            </div>
            
            @if($projectCommission->projectCommissionDocuments && $projectCommission->projectCommissionDocuments->count() > 0)
                <div class="space-y-3">
                    @foreach($projectCommission->projectCommissionDocuments->sortByDesc('created_at') as $document)
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-green-500">
                            <div class="flex justify-between items-center">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('projectcommission_document_download', $document) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                            {{ $document->original_name ?: 'Arxiu sense nom' }}
                                        </a>
                                        <span class="text-sm text-gray-500">
                                            ({{ $document->file_size ? number_format($document->file_size / 1024, 2) . ' KB' : 'Mida desconeguda' }})
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        <strong>{{ $document->professional->name ?? 'Usuari desconegut' }} {{ $document->professional->surname1 ?? '' }}</strong>
                                        <span class="ml-2">{{ $document->created_at ? $document->created_at->format('d/m/Y H:i') : 'Data desconeguda' }}</span>
                                    </div>
                                </div>
                                <x-partials.modal id="deleteProjectCommissionDocument{{ $document->id }}" msj="Estàs segur que vols eliminar aquest arxiu?" btnText="Eliminar" class="btn-xs btn-error">
                                    <form action="{{ route('projectcommission_document_delete', $document) }}" method="POST">
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
                <p class="text-gray-500 italic">No hi ha arxius per aquest projecte/comissió.</p>
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
            
            @if($projectCommission->projectNotes->count() > 0)
                <div class="space-y-4">
                    @foreach($projectCommission->projectNotes->sortByDesc('created_at') as $note)
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500">
                            <div class="flex justify-between items-start mb-2">
                                <div class="text-sm text-gray-600">
                                    <strong>{{ $note->professional->name }} {{ $note->professional->surname1 }}</strong>
                                    <span class="ml-2">{{ $note->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex gap-2">
                                    <button class="btn btn-xs btn-info" data-note-id="{{ $note->id }}" data-note-content="{{ $note->notes }}" onclick="openEditNoteModal(this.dataset.noteId, this.dataset.noteContent)">
                                        Editar
                                    </button>
                                    {{-- TODO: Change the "Eliminar" button to a red trash icon --}}
                                    <x-partials.modal id="deleteProjectCommissionNote{{ $note->id }}" msj="Estàs segur que vols eliminar aquesta nota?" btnText="Eliminar" class="btn-xs btn-error">
                                        <form action="{{ route('projectcommission_note_delete', $note) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error">Acceptar</button>
                                        </form>
                                    </x-partials.modal>
                                </div>
                            </div>
                            <p class="text-gray-800 break-words whitespace-pre-wrap">{{ $note->notes }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">No hi ha notes per aquest projecte/comissió.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal to add note -->
<dialog id="addNoteModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Afegir Nova Nota</h3>
        <form action="{{ route('projectcommission_note_add', $projectCommission) }}" method="POST">
            @csrf
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Nota:</span>
                </label>
                <textarea name="notes" class="textarea textarea-bordered w-full" rows="4" placeholder="Escriu la nota aquí..." required></textarea>
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-sm" onclick="this.closest('dialog').close()">Cancel·lar</button>
                <button type="submit" class="btn btn-sm btn-info">Afegir Nota</button>
            </div>
        </form>
    </div>
</dialog>

<!-- Modal to edit note -->
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
                <button type="button" class="btn btn-sm" onclick="this.closest('dialog').close()">Cancel·lar</button>
                <button type="submit" class="btn btn-sm btn-info">Desar Canvis</button>
            </div>
        </form>
    </div>
</dialog>

<!-- Modal to upload files -->
<dialog id="addFileModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Pujar Arxius</h3>
        <form action="{{ route('projectcommission_document_add', $projectCommission) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Seleccionar Arxius:</span>
                </label>
                <input type="file" name="files[]" class="file-input file-input-bordered w-full" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.txt">
                <div class="label">
                    <span class="label-text-alt">Formats suportats: <br> PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG, TXT</span>
                </div>
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-sm" onclick="this.closest('dialog').close()">Cancel·lar</button>
                <button type="submit" class="btn btn-sm btn-info">Pujar Arxius</button>
            </div>
        </form>
    </div>
</dialog>

<script>
function openEditNoteModal(noteId, noteText) {
    document.getElementById('editNoteText').value = noteText;
    document.getElementById('editNoteForm').action = `/projectcommission/notes/${noteId}`;
    document.getElementById('editNoteModal').showModal();
}
</script>

@include('components.layout.mainToasts')

@endsection
