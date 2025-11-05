<table class="table w-full table-xs table-zebra table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">ID</th>
            <th class="px-4 py-2 text-left">Nom/Títol</th>
            <th class="px-4 py-2 text-left">Estat</th>
            <th class="px-4 py-2 text-left">Professional responsable</th>
            <th class="px-4 py-2 text-left">Tipus</th>
            <th class="px-4 py-2 text-left">Data d'inici</th>
            <th class="px-4 py-2 text-right">Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($projectCommissions as $projectCommission)
            @if ($projectCommission->status == 'Inactiu')
                <tr class="hover:bg-base-200 transition-colors">
                    <td class="px-4 py-2">{{ $projectCommission->id }}</td>
                    <td class="px-4 py-2 font-medium">{{ $projectCommission->name }}</td>
                    <td class="px-4 py-2">
                        <span class="badge badge-dash {{ $projectCommission->status === 'Inactiu' ? 'badge-error' : 'badge-sucess' }}">
                            {{ $projectCommission->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        @if($projectCommission->responsibleProfessional)
                            <a href="{{ route('professional_show', $projectCommission->responsibleProfessional->id) }}" 
                                class="link link-hover link-info">
                                {{ $projectCommission->responsibleProfessional->name }} {{ $projectCommission->responsibleProfessional->surname1 }}
                            </a>
                        @else
                            <span class="text-base-content/50">No assignat</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $projectCommission->type }}</td>
                    <td class="px-4 py-2">{{ $projectCommission->start_date }}</td>
                    <td class="px-4 py-2 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('projectcommission_show', $projectCommission) }}" class="btn btn-xs btn-info">Veure</a>
                            <form action="{{ route('projectcommission_activate', $projectCommission) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-xs btn-success">
                                    Activar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>