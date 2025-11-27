<table class="table w-full table-xs table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">Nom</th>
            <th class="px-4 py-2 text-left">Tipus</th>
            <th class="px-4 py-2 text-left">Pujat per</th>
            <th class="px-4 py-2 text-left">Data</th>
        </tr>
    </thead>
    <tbody>
        @foreach($documents as $document)
            <tr class="hover:bg-base-300 transition-colors">
                <td class="px-4 py-2 font-medium">
                    <a href="{{ route('global_document_download', $document) }}" class="text-primary hover:underline">
                        {{ Str::limit($document->original_name, 40) }}
                    </a>
                </td>
                <td class="px-4 py-2">{{ $document->document_type ?? 'Altres' }}</td>
                <td class="px-4 py-2">
                    @if($document->uploadedByProfessional)
                        {{ $document->uploadedByProfessional->name }} {{ $document->uploadedByProfessional->surname1 }}
                    @else
                        
                    @endif
                </td>
                <td class="px-4 py-2">{{ $document->created_at ? \Carbon\Carbon::parse($document->created_at)->format('d/m/Y') : '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@if($documents->hasPages())
    <div class="mt-4">
        {{ $documents->links() }}
    </div>
@endif

