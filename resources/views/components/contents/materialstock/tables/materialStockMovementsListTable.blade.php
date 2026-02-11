<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Data</th>
            <th class="px-4 py-2 text-left">Tipus</th>
            <th class="px-4 py-2 text-left">Item</th>
            <th class="px-4 py-2 text-right">Quantitat</th>
            <th class="px-4 py-2 text-left">Persona</th>
            <th class="px-4 py-2 text-right">Acció</th>
        </tr>
    </thead>
    <tbody>
        @foreach($movements as $movement)
            <tr class="hover:bg-base-300 transition-colors text-xs">
                <td class="px-4 py-2">{{ $movement->movement_date?->format('d/m/Y') }}</td>
                <td class="px-4 py-2">
                    <span class="badge badge-dash whitespace-nowrap text-center min-w-0 max-w-full truncate {{ $movement->type === 'Entrada' ? 'badge-success' : 'badge-warning' }}">
                        {{ $movement->type }}
                    </span>
                </td>
                <td class="px-4 py-2">{{ $movement->materialStockItem->name ?? '' }}</td>
                <td class="px-4 py-2 text-right">{{ $movement->quantity }}</td>
                <td class="px-4 py-2">{{ $movement->person }}</td>
                <td class="px-4 py-2 text-right">
                    <a href="{{ route('material_stock_movement_show', $movement) }}" class="btn btn-xs btn-info">Veure</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
