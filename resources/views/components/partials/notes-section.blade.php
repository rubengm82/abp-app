@props([
    'items' => collect(),
    'title' => 'Notes',
    'addAction' => null,
    'deleteRoute' => null,
    'editRoute' => null,
    'createdByField' => null,
])

<div class="card bg-base-100 text-base-content shadow-xl mt-6" id="notes-section">
    <div class="card-body">
        {{-- Title and Button Add --}}
        <div class="flex justify-between items-center mb-4">
            <h2 class="card-title text-xl">{{ $title }}</h2>
            @if($addAction)
                <button class="btn btn-sm btn-primary" onclick="document.getElementById('addNoteModal').showModal()">Afegir Nota</button>
            @endif
        </div>

        {{-- List Notes --}}
        @if($items->count())
            <div class="space-y-4">
                @foreach($items->sortByDesc('created_at') as $item)
                    <div class="bg-base-200 p-4 rounded-lg border-l-4 border-blue-500">
                        <div class="flex justify-between items-start mb-2">
                            <div class="text-sm text-gray-600">
                                <strong>{{ $createdByField ? ($item->$createdByField->name ?? 'Usuari desconegut') : 'Usuari desconegut' }}
                                {{ $createdByField ? ($item->$createdByField->surname1 ?? '') : '' }}</strong>
                                <span class="ml-2">{{ $item->created_at?->format('d/m/Y H:i') ?? 'Data desconeguda' }}</span>
                            </div>
                            <div class="flex gap-2">
                                {{-- Botón editar --}}
                                <button class="btn btn-xs btn-info"
                                    onclick="openEditNoteModal('{{ route($editRoute, $item) }}', `{{ addslashes($item->notes ?? $item->text ?? '') }}`)">
                                    Editar
                                </button>

                                {{-- Modal eliminar --}}
                                @if($deleteRoute)
                                    <x-partials.modal 
                                        id="deleteNote{{ $item->id }}" 
                                        msj="Estàs segur que vols eliminar aquesta nota?" 
                                        btnText="Eliminar"
                                        class="btn-xs btn-error"
                                    >
                                        <form action="{{ route($deleteRoute, $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error">Acceptar</button>
                                        </form>
                                    </x-partials.modal>
                                @endif
                            </div>
                        </div>
                        <p class="text-base-content break-words whitespace-pre-wrap">{{ $item->notes ?? $item->text ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 italic">No hi ha {{ Str::lower($title) }} disponibles.</p>
        @endif
    </div>
</div>

{{-- Modal añadir nota --}}
@if($addAction)
<dialog id="addNoteModal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg mb-4">Afegir {{ Str::singular($title) }}</h3>
    <form action="{{ $addAction }}" method="POST">
      @csrf
      <div class="form-control mb-4">
        <label class="label"><span class="label-text">Nota:</span></label>
        <textarea name="notes" class="textarea textarea-bordered w-full" rows="4" placeholder="Escriu la nota aquí..." required></textarea>
      </div>
      <div class="modal-action">
        <button type="button" class="btn btn-sm" onclick="document.getElementById('addNoteModal').close()">Cancel·lar</button>
        <button type="submit" class="btn btn-sm btn-info">Afegir Nota</button>
      </div>
    </form>
  </div>
</dialog>
@endif

{{-- Modal edit note --}}
<dialog id="editNoteModal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg mb-4">Editar {{ Str::singular($title) }}</h3>
    <form id="editNoteForm" method="POST">
      @csrf
      @method('PUT')
      <div class="form-control mb-4">
        <label class="label"><span class="label-text">Nota:</span></label>
        <textarea name="notes" id="editNoteText" class="textarea textarea-bordered w-full" rows="4" required></textarea>
      </div>
      <div class="modal-action">
        <button type="button" class="btn btn-sm" onclick="document.getElementById('editNoteModal').close()">Cancel·lar</button>
        <button type="submit" class="btn btn-sm btn-info">Desar Canvis</button>
      </div>
    </form>
  </div>
</dialog>

<script>
function openEditNoteModal(url, noteText) {
    document.getElementById('editNoteText').value = noteText;
    document.getElementById('editNoteForm').action = url;
    document.getElementById('editNoteModal').showModal();
}
</script>
