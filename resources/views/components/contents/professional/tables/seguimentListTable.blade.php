<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Nom</th>
            <th class="px-4 py-2 text-left">Primer cognom</th>
            <th class="px-4 py-2 text-left">Segon cognom</th>
            <th class="px-4 py-2 text-left">Rol</th>
            <th class="px-4 py-2 text-left">Data última nota</th>
            <th class="px-4 py-2 text-right">Acció</th>
        </tr>
    </thead>
    <tbody>
        @foreach($professionals as $professional)
            <tr class="hover:bg-base-300 transition-colors text-xs">
                <td class="px-4 py-2">{{ $professional->name }}</td>
                <td class="px-4 py-2">{{ $professional->surname1 }}</td>
                <td class="px-4 py-2">{{ $professional->surname2 }}</td>
                <td class="px-4 py-2">{{ $professional->role ?? '—' }}</td>
                <td class="px-4 py-2">
                    @php $lastNote = $professional->notes->first(); @endphp
                    @if($lastNote)
                        {{ $lastNote->created_at->format('d/m/Y H:i') }}
                    @endif
                </td>
                <td class="px-4 py-2 text-right">
                    <a href="{{ route('seguiment_show', $professional) }}" class="btn btn-xs btn-info">Veure</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
