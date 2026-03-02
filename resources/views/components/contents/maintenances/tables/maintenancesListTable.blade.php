@if($maintenances->isEmpty() && ($searchPerformed ?? false))
    <div class="text-center py-8 text-base-content/70">No s'han trobat resultats. Proveu amb altres paraules.</div>
@else
<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Nom del Manteniment</th>
            <th class="px-4 py-2 text-left">Responsable del Manteniment</th>
            <th class="px-4 py-2 text-left">Descripció</th>
            <th class="px-4 py-2 text-left">Data d'inici</th>
            <th class="px-4 py-2 text-left">Data fi</th>
            <th class="px-4 py-2 text-left">Estat</th>
            @if($isDeactivated)
                <th class="px-4 py-2 text-right">Accions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($maintenances as $maintenance)
            <tr class="hover:bg-base-300 transition-colors text-xs {{ !$isDeactivated ? 'cursor-pointer' : '' }}" @if(!$isDeactivated) data-href="{{ route('maintenance_show', $maintenance) }}" role="link" tabindex="0" @endif>
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
                @if($isDeactivated)
                    <td class="px-4 py-2 text-right">
                        <div class="flex justify-end gap-2">
                            <form action="{{ route('maintenance_activate', $maintenance) }}" method="POST" style="display:inline;">
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
@endif

{{-- <div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $maintenances->links('pagination::daisyui-pagination') }}
   </div>
</div> --}}