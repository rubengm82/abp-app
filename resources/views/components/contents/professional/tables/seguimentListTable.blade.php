@if($professionals->isEmpty() && ($searchPerformed ?? false))
    <div class="text-center py-8 text-base-content/70">No s'han trobat resultats. Proveu amb altres paraules.</div>
@else
<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Nom</th>
            <th class="px-4 py-2 text-left">Rol</th>
            <th class="px-4 py-2 text-left">Estat</th>
            <th class="px-4 py-2 text-center">Notes</th>
            <th class="px-4 py-2 text-left">Data última nota</th>
        </tr>
    </thead>
    <tbody>
        @foreach($professionals as $professional)
            @php $lastNote = $professional->notes->first(); @endphp
            <tr class="hover:bg-base-300 transition-colors text-xs cursor-pointer" data-href="{{ route('seguiment_show', $professional) }}" role="link" tabindex="0">
                <td class="px-4 py-2">
                    <a href="{{ route('professional_show', $professional->id) }}" class="link link-hover text-info link-info">
                        {{ trim($professional->name . ' ' . $professional->surname1 . ' ' . ($professional->surname2 ?? '')) }}
                    </a>
                </td>
                <td class="px-4 py-2">{{ $professional->role ?? '' }}</td>
                <td class="px-4 py-2">
                    @php
                        $statusClasses = [
                            'Fixe' => 'badge-info',
                            'Eventual' => 'badge-success',
                            'Suplent habitual' => 'badge-warning',
                        ];
                        $badgeClass = $statusClasses[$professional->employment_status] ?? 'badge-error';
                    @endphp
                    <span class="badge badge-dash {{ $badgeClass }}">{{ $professional->employment_status ?? '' }}</span>
                </td>
                <td class="px-4 py-2 text-center">
                    <span class="badge badge-sm badge-ghost">{{ $professional->notes->count() }}</span>
                </td>
                <td class="px-4 py-2">
                    @if($lastNote)
                        {{ $lastNote->created_at->format('d/m/Y H:i') }}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
