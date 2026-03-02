<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Títol</th>
            <th class="px-4 py-2 text-left">Professional responsable</th>
            <th class="px-4 py-2 text-left">Tipus</th>
            <th class="px-4 py-2 text-left">Data d'inici</th>
            <th class="px-4 py-2 text-left">Estat</th>
            @if($isDeactivated)
                <th class="px-4 py-2 text-right">Accions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($projectCommissions as $projectCommission)
            <tr class="hover:bg-base-300 transition-colors text-xs cursor-pointer" data-href="{{ route('projectcommission_show', $projectCommission) }}" role="link" tabindex="0">
                <td class="px-4 py-2 font-medium">{{ $projectCommission->name }}</td>
                <td class="px-4 py-2">
                    @if($projectCommission->responsibleProfessional)
                        <a href="{{ route('professional_show', $projectCommission->responsibleProfessional->id) }}"
                            class="link link-hover text-info link-info">
                            {{ $projectCommission->responsibleProfessional->name . ' ' . $projectCommission->responsibleProfessional->surname1 }}
                        </a>
                    @else
                        <span class="text-base-content/50">No assignat</span>
                    @endif
                </td>
                <td class="px-4 py-2">{{ $projectCommission->type ?: 'No especificat' }}</td>
                <td class="px-4 py-2">{{ $projectCommission->start_date ? \Carbon\Carbon::parse($projectCommission->start_date)->format('d/m/Y') : 'No especificat' }}</td>
                <td class="px-4 py-2">
                    @if(($projectCommission->status ?? '') === 'Actiu')
                        <span class="badge badge-dash badge-success">{{ $projectCommission->status }}</span>
                    @elseif(($projectCommission->status ?? '') === 'Pendent')
                        <span class="badge badge-dash badge-warning">{{ $projectCommission->status }}</span>
                    @else
                        <span class="badge badge-dash badge-info">{{ $projectCommission->status ?? 'Tancat' }}</span>
                    @endif
                </td>
                @if($isDeactivated)
                    <td class="px-4 py-2 text-right">
                        <div class="flex justify-end gap-2">
                            <form action="{{ route('projectcommission_activate', $projectCommission) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-xs btn-success">Activar</button>
                            </form>
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>