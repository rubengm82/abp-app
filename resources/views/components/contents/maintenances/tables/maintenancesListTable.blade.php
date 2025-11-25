<table class="table w-full table-xs table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">Nom del Manteniment</th>
            <th class="px-4 py-2 text-left">Resposable del Manteniment</th>
            <th class="px-4 py-2 text-left">Descripció</th>
            <th class="px-4 py-2 text-left">Data d'inici</th>
            <th class="px-4 py-2 text-left">Data fi</th>
            <th class="px-4 py-2 text-right">Acció</th>
        </tr>
    </thead>
    <tbody>
        @foreach($maintenances as $maintenance)
            <tr class="hover:bg-base-300 transition-colors">
                <td class="px-4 py-2">{{ Str::limit($maintenance->name_maintenance, 60) }}</td>
                <td class="px-4 py-2">{{ Str::limit($maintenance->responsible_maintenance, 60) }}</td>
                <td class="px-4 py-2">
                    <div title="{{ $maintenance->description }}">
                        {{ Str::limit($maintenance->description, 60) }}</td>
                    </div>
                <td class="px-4 py-2">{{ $maintenance->opening_date_maintenance ? \Carbon\Carbon::parse($maintenance->opening_date_maintenance)->format('d/m/Y') : 'No especificada' }}</td>
                <td class="px-4 py-2">{{ $maintenance->ending_date_maintenance ? \Carbon\Carbon::parse($maintenance->ending_date_maintenance)->format('d/m/Y') : 'No especificada' }}</td>
                <td class="px-4 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('maintenance_show', $maintenance) }}" class="btn btn-xs btn-info">Veure</a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $maintenances->links('pagination::daisyui-pagination') }}
   </div>
</div>