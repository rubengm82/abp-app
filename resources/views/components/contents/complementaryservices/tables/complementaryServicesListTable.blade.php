@if($complementaryServices->isEmpty() && ($searchPerformed ?? false))
    <div class="text-center py-8 text-base-content/70">No s'han trobat resultats. Proveu amb altres paraules.</div>
@else
<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Tipus de Servei</th>
            <th class="px-4 py-2 text-left">Responsable</th>
            <th class="px-4 py-2 text-left">Data d'Inici</th>
            <th class="px-4 py-2 text-left">Data fi</th>
            <th class="px-4 py-2 text-left">Estat</th>
            @if($isDeactivated)
                <th class="px-4 py-2 text-right">Accions</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @foreach($complementaryServices as $service)
            <tr class="hover:bg-base-300 transition-colors text-xs {{ !$isDeactivated ? 'cursor-pointer' : '' }}" @if(!$isDeactivated) data-href="{{ route('complementaryservice_show', $service) }}" role="link" tabindex="0" @endif>

                <td class="px-4 py-2">
                    {{ $service->service_type ? Str::limit($service->service_type, 50) : 'No especificat' }}
                </td>

                <td class="px-4 py-2">
                    {{ $service->service_responsible ? Str::limit($service->service_responsible, 50) : 'No especificat' }}
                </td>

                <td class="px-4 py-2">
                    {{ $service->start_date
                        ? \Carbon\Carbon::parse($service->start_date)->format('d/m/Y')
                        : 'No especificat' }}
                </td>

                <td class="px-4 py-2">
                    {{ $service->end_date
                        ? \Carbon\Carbon::parse($service->end_date)->format('d/m/Y')
                        : 'No especificat' }}
                </td>

                <td class="px-4 py-2">
                    @if(($service->status ?? '') === 'Obert')
                        <span class="badge badge-dash whitespace-nowrap badge-warning">{{ $service->status }}</span>
                    @elseif(($service->status ?? '') === 'Tancat')
                        <span class="badge badge-dash whitespace-nowrap badge-success">{{ $service->status }}</span>
                    @else
                        <span class="badge badge-dash whitespace-nowrap badge-ghost">{{ $service->status ?? 'No especificat' }}</span>
                    @endif
                </td>

                @if($isDeactivated)
                    <td class="px-4 py-2 text-right">
                        <div class="flex justify-end gap-2">
                            <form action="{{ route('complementaryservice_activate', $service) }}" method="POST" style="display:inline;">
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
       {{ $complementaryServices->links('pagination::daisyui-pagination') }}
   </div>
</div> --}}
