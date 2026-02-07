<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Nom del Manteniment</th>
            <th class="px-4 py-2 text-left">Responsable del Manteniment</th>
            <th class="px-4 py-2 text-left">Descripció</th>
            <th class="px-4 py-2 text-left">Data d'inici</th>
            <th class="px-4 py-2 text-left">Data fi</th>
            <th class="px-4 py-2 text-left">Estat</th>
            <th class="px-4 py-2 text-right">{{ $isDeactivated ? 'Accions' : 'Acció' }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($maintenances as $maintenance)
            <tr class="hover:bg-base-300 transition-colors text-xs">
                <td class="px-4 py-2">{{ Str::limit($maintenance->name_maintenance, 60) }}</td>
                <td class="px-4 py-2">{{ Str::limit($maintenance->responsible_maintenance, 60) }}</td>
                <td class="px-4 py-2">
                    <div title="{{ $maintenance->description }}">
                        {{ Str::limit($maintenance->description, 60) }}
                    </div>
                </td>
                <td class="px-4 py-2">{{ $maintenance->opening_date_maintenance ? \Carbon\Carbon::parse($maintenance->opening_date_maintenance)->format('d/m/Y') : 'No especificat' }}</td>
                <td class="px-4 py-2">{{ $maintenance->ending_date_maintenance ? \Carbon\Carbon::parse($maintenance->ending_date_maintenance)->format('d/m/Y') : 'No especificat' }}</td>
                <td class="px-4 py-2">
                    @if(($maintenance->status ?? '') === 'Obert')
                        <span class="badge badge-dash whitespace-nowrap badge-error">{{ $maintenance->status }}</span>
                    @elseif(($maintenance->status ?? '') === 'Tancat')
                        <span class="badge badge-dash whitespace-nowrap badge-success">{{ $maintenance->status }}</span>
                    @elseif(($maintenance->status ?? '') === 'En resol·lució')
                        <span class="badge badge-dash whitespace-nowrap badge-warning">{{ $maintenance->status }}</span>
                    @else
                        <span class="badge badge-dash whitespace-nowrap badge-ghost">{{ $maintenance->status ?? 'No especificat' }}</span>
                    @endif
                </td>
                <td class="px-4 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        @if(!$isDeactivated)
                            <a href="{{ route('maintenance_show', $maintenance) }}" class="btn btn-xs btn-info">Veure</a>
                        @endif

                        @if($isDeactivated)
                            <form action="{{ route('maintenance_activate', $maintenance) }}" method="POST" style="display:inline;">
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

{{-- <div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $maintenances->links('pagination::daisyui-pagination') }}
   </div>
</div> --}}