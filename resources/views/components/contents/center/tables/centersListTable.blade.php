<table class="table w-full table-xs {{ $isDeactivated ? 'table-zebra' : '' }} table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">Nom</th>
            <th class="px-4 py-2 text-left">Adreça</th>
            <th class="px-4 py-2 text-left">Telèfon</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-right">{{ $isDeactivated ? 'Accions' : 'Acció' }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($centers as $center)
            <tr class="hover:bg-{{ $isDeactivated ? 'base-200' : 'base-300' }} transition-colors">
                <td class="px-4 py-2 font-medium">{{ $center->name }}</td>
                <td class="px-4 py-2">{{ $center->address }}</td>
                <td class="px-4 py-2">{{ $center->phone }}</td>
                <td class="px-4 py-2">{{ $center->email }}</td>
                <td class="px-4 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        @if(!$isDeactivated)
                            <a href="{{ route('center_show', $center) }}" class="btn btn-xs btn-info">Veure</a>
                        @endif
                        @if($isDeactivated)
                            <form action="{{ route('center_activate', $center) }}" method="POST" style="display:inline;">
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