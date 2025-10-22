@props([
    'items' => collect(),
    'title' => 'Documents',
    'uploadAction' => null,
    'downloadRoute' => null,
    'deleteRoute' => null,
    'uploadedByField' => null,
])

<div class="card bg-base-100 text-base-content shadow-xl mt-6">
    <div class="card-body">
        <div class="flex justify-between items-center mb-4">
            <h2 class="card-title text-xl" id="documents-section">{{ $title }}</h2>
            @if($uploadAction)
                <button class="btn btn-sm btn-primary" data-open-modal="addDocumentModal">Pujar Document</button>
            @endif
        </div>

        {{-- List Documents --}}
        @if($items->count())
            <div class="space-y-3">
                @foreach($items->sortByDesc('created_at') as $item)
                    <div class="bg-base-200 p-4 rounded-lg border-l-4 border-green-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <a href="{{ $downloadRoute ? route($downloadRoute, $item) : '#' }}"
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                   {{ $item->original_name ?? 'Sense nom' }}
                                </a>
                                <div class="text-sm text-gray-600 mt-1">
                                    {{ $uploadedByField ? ($item->$uploadedByField->name ?? '') : '' }}
                                    — {{ $item->created_at?->format('d/m/Y H:i') }}
                                </div>
                            </div>

                            @if($deleteRoute)
                                <x-partials.modal 
                                    id="deleteDocument{{ $item->id }}" 
                                    msj="Estàs segur que vols eliminar aquest document?" 
                                    btnText="Eliminar"
                                    class="btn-xs btn-error"
                                >
                                    <form action="{{ route($deleteRoute, $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-error" data-loading-text="Eliminant...">Acceptar</button>
                                    </form>
                                </x-partials.modal>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 italic">No hi ha documents disponibles.</p>
        @endif
    </div>
</div>

{{-- Modal Upload Document --}}
@if($uploadAction)
<dialog id="addDocumentModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Pujar Document</h3>
        <form action="{{ $uploadAction }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="document" class="file-input file-input-bordered w-full mt-4" required>
            <div class="modal-action">
                <button type="button" class="btn btn-sm" data-close-modal="addDocumentModal">Cancel·lar</button>
                <button type="submit" class="btn btn-sm btn-info" data-loading-text="Pujant...">Pujar</button>
            </div>
        </form>
    </div>
</dialog>
@endif

@push('scripts_partials_components')
    @vite('resources/js/customs/partials/documents-section.js')
@endpush
