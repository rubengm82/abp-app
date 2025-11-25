<table class="table w-full table-xs table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">Tipus de Servei</th>
            <th class="px-4 py-2 text-left">Responsable</th>
            <th class="px-4 py-2 text-left">Data d'Inici</th>
            <th class="px-4 py-2 text-left">Data fi</th>
            <th class="px-4 py-2 text-right">Acció</th>
        </tr>
    </thead>

    <tbody>
        @foreach($complementaryServices as $service)
            <tr class="hover:bg-base-300 transition-colors">

                <td class="px-4 py-2">
                    {{ Str::limit($service->service_type, 50) ?? 'No especificat' }}
                </td>

                <td class="px-4 py-2">
                    {{ Str::limit($service->service_responsible, 50) ?? 'No especificat' }}
                </td>

                <td class="px-4 py-2">
                    {{ $service->start_date 
                        ? \Carbon\Carbon::parse($service->start_date)->format('d/m/Y') 
                        : 'No especificada' }}
                </td>
                
                <td class="px-4 py-2">
                    {{ $service->start_date 
                        ? \Carbon\Carbon::parse($service->end_date)->format('d/m/Y') 
                        : 'No especificada' }}
                </td>

                <td class="px-4 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('complementaryservice_show', $service) }}" 
                           class="btn btn-xs btn-info">
                            Veure
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $complementaryServices->links('pagination::daisyui-pagination') }}
   </div>
</div>
