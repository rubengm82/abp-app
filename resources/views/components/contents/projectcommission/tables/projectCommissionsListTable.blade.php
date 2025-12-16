<table class="table w-full table-xs {{ $isDeactivated ? 'table-zebra' : '' }} table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Nom/Títol</th>
            <th class="px-4 py-2 text-left">Professional responsable</th>
            <th class="px-4 py-2 text-left">Tipus</th>
            <th class="px-4 py-2 text-left">Data d'inici</th>
            <th class="px-4 py-2 text-right">{{ $isDeactivated ? 'Accions' : 'Acció' }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($projectCommissions as $projectCommission)
            <tr class="hover:bg-base-300 transition-colors text-xs">
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
                <td class="px-4 py-2">{{ $projectCommission->type }}</td>
                <td class="px-4 py-2">{{ $projectCommission->start_date }}</td>
                <td class="px-4 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        @if(!$isDeactivated)
                            <a href="{{ route('projectcommission_show', $projectCommission) }}" class="btn btn-xs btn-info">Veure</a>
                        @endif
                        @if($isDeactivated)
                            <form action="{{ route('projectcommission_activate', $projectCommission) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-xs btn-success">Activar</button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>