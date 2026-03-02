@if($documents->isEmpty() && ($searchPerformed ?? false))
    <div class="text-center py-8 text-base-content/70">No s'han trobat resultats. Proveu amb altres paraules.</div>
@else
<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Nom</th>
            <th class="px-4 py-2 text-left">Tipus</th>
            <th class="px-4 py-2 text-left">Pujat per</th>
            <th class="px-4 py-2 text-left">Origen</th>
            <th class="px-4 py-2 text-left">Nota</th>
            <th class="px-4 py-2 text-left">Data</th>
            <th class="px-4 py-2 text-right">Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($documents as $document)
            <tr class="hover:bg-base-300 transition-colors text-xs">
                <td class="px-4 py-2 font-medium">
                    {{ Str::limit($document->original_name, 40) }}
                </td>
                <td class="px-4 py-2">{{ $document->document_type ?? 'Altres' }}</td>
                <td class="px-4 py-2">
                    @if($document->uploadedByProfessional)
                        {{ $document->uploadedByProfessional->name }} {{ $document->uploadedByProfessional->surname1 }}
                    @else
                        —
                    @endif
                </td>
                <td class="px-4 py-2">
                    @if($document->origin_url)
                        <a href="{{ $document->origin_url }}" class="link link-info link-hover">{{ $document->origin }}</a>
                    @else
                        {{ $document->origin }}
                    @endif
                </td>
                <td class="px-4 py-2 max-w-[200px] break-words">{{ $document->note ? Str::limit($document->note, 50) : '' }}</td>
                <td class="px-4 py-2">{{ $document->created_at ? \Carbon\Carbon::parse($document->created_at)->format('d/m/Y') : '' }}</td>
                <td class="px-4 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        <form action="{{ route('document_restore', $document) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-xs btn-success">Restaurar</button>
                        </form>
                        <x-partials.modal
                            id="destroyDocument{{ $document->id }}"
                            msj="Estàs segur que vols eliminar definitivament aquest document? No es podrà desfer."
                            btnText="Eliminar"
                            class="btn-xs btn-error"
                        >
                            <form action="{{ route('document_destroy_permanent', $document) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-error" data-loading-text="Eliminant...">Sí, eliminar</button>
                            </form>
                        </x-partials.modal>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
