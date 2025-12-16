<table class="table w-full table-xs table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">Nom</th>
            <th class="px-4 py-2 text-left">Tipus</th>
            <th class="px-4 py-2 text-left">Pujat per</th>
            <th class="px-4 py-2 text-left">Origen</th>
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
                <td class="px-4 py-2">
                    @if($document->origin_url)
                        <a href="{{ $document->origin_url }}" class="link link-warning">{{ $document->origin }}</a>
                    @else
                        {{ $document->origin }}
                    @endif
                </td>
                <td class="px-4 py-2">{{ $document->created_at ? \Carbon\Carbon::parse($document->created_at)->format('d/m/Y') : '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- <div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $documents->links('pagination::daisyui-pagination') }}
   </div>
</div> --}}

