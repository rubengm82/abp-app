<table class="table w-full table-xs table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">ID</th>
            <th class="px-4 py-2 text-left">Professional</th>
            <th class="px-4 py-2 text-center">Samarreta</th>
            <th class="px-4 py-2 text-center">Pantaló</th>
            <th class="px-4 py-2 text-center">Sabata</th>
            <th class="px-4 py-2 text-left">Data Assignació</th>
            <th class="px-4 py-2 text-left">Assignat per</th>
            <th class="px-4 py-2 text-left">Observacions</th>
            <th class="px-4 py-2 text-right">Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($materialAssignments as $assignment)
            <tr class="hover:bg-base-300 transition-colors">
                <td class="px-4 py-2">{{ $assignment->id }}</td>
                <td class="px-4 py-2 font-medium">
                    <a href="{{ route('professional_show', $assignment->professional->id) }}" 
                        class="link link-hover link-info">
                        {{ $assignment->professional->name }} {{ $assignment->professional->surname1 }}
                    </a>
                </td>
                <td class="px-4 py-2 text-center">
                    @if($assignment->shirt_size)
                        <span class="badge badge-dash badge-info">{{ $assignment->shirt_size }}</span>
                    @else
                        <span class="text-base-content/50">-</span>
                    @endif
                </td>
                <td class="px-4 py-2 text-center">
                    @if($assignment->pants_size)
                        <span class="badge badge-dash badge-info">{{ $assignment->pants_size }}</span>
                    @else
                        <span class="text-base-content/50">-</span>
                    @endif
                </td>
                <td class="px-4 py-2 text-center">
                    @if($assignment->shoe_size)
                        <span class="badge badge-dash badge-info">{{ $assignment->shoe_size }}</span>
                    @else
                        <span class="text-base-content/50">-</span>
                    @endif
                </td>
                <td class="px-4 py-2">{{ $assignment->assignment_date->format('d/m/Y') }}</td>
                <td class="px-4 py-2">
                    @if($assignment->assignedBy)
                        {{ $assignment->assignedBy->name }} {{ $assignment->assignedBy->surname1 }}
                    @else
                        <span class="text-base-content/50">No especificat</span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    @if($assignment->observations)
                        <span class="text-sm" title="{{ $assignment->observations }}">
                            {{ Str::limit($assignment->observations, 30) }}
                        </span>
                    @else
                        <span class="text-base-content/50"></span>
                    @endif
                </td>
                <td class="px-4 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('materialassignment_show', $assignment) }}" class="btn btn-xs btn-info">Veure</a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>