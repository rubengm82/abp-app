@if($materialAssignments->isEmpty() && ($searchPerformed ?? false))
    <div class="text-center py-8 text-base-content/70">No s'han trobat resultats. Proveu amb altres paraules.</div>
@else
<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Professional</th>
            <th class="px-4 py-2 text-center">Samarreta</th>
            <th class="px-4 py-2 text-center">Pantaló</th>
            <th class="px-4 py-2 text-center">Sabata</th>
            <th class="px-4 py-2 text-left">Data Assignació</th>
            <th class="px-4 py-2 text-left">Assignat per</th>
            <th class="px-4 py-2 text-left">Observacions</th>
            <th class="px-4 py-2 text-left">Signatura</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($materialAssignments as $assignment)
            <tr class="hover:bg-base-300 transition-colors text-xs cursor-pointer" data-href="{{ route('materialassignment_show', $assignment) }}" role="link" tabindex="0">
                <td class="px-4 py-2 font-medium">
                    <a href="{{ route('professional_show', $assignment->professional->id) }}" 
                        class="link link-hover text-info link-info">
                        {{ $assignment->professional->name }} {{ $assignment->professional->surname1 }}
                    </a>
                </td>
                <td class="px-4 py-2 text-center">
                    @if($assignment->shirt_size)
                        <span class="badge badge-dash badge-info">{{ $assignment->shirt_size }}</span>
                    @else
                        <span class="text-base-content/50"></span>
                    @endif
                </td>
                <td class="px-4 py-2 text-center">
                    @if($assignment->pants_size)
                        <span class="badge badge-dash badge-info">{{ $assignment->pants_size }}</span>
                    @else
                        <span class="text-base-content/50"></span>
                    @endif
                </td>
                <td class="px-4 py-2 text-center">
                    @if($assignment->shoe_size)
                        <span class="badge badge-dash badge-info">{{ $assignment->shoe_size }}</span>
                    @else
                        <span class="text-base-content/50"></span>
                    @endif
                </td>
                <td class="px-4 py-2">{{ $assignment->assignment_date->format('d/m/Y') }}</td>
                <td class="px-4 py-2">
                    @if($assignment->assignedBy)
                        <a href="{{ route('professional_show', $assignment->assignedBy->id) }}" class="link link-hover text-info link-info">
                            {{ $assignment->assignedBy->name }} {{ $assignment->assignedBy->surname1 }}
                        </a>
                    @else
                        <span class="text-base-content/50">No especificat</span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    @if($assignment->observations)
                        <span class="text-sm text-base-content/50" title="{{ $assignment->observations }}">
                            {{ Str::limit($assignment->observations, 30) }}
                        </span>
                    @else
                        <span class="text-base-content/50"></span>
                    @endif
                </td>
                <td>
                    @if($assignment->signature)
                        <span class="badge badge-dash whitespace-nowrap badge-info">Signat</span>
                    @else
                        <span class="badge badge-dash whitespace-nowrap badge-warning">No signat</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif