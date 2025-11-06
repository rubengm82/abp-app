<table class="table w-full table-xs table-zebra table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">Nom</th>
            <th class="px-4 py-2 text-left">Adreça</th>
            <th class="px-4 py-2 text-left">Telèfon</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-right">Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($centers as $center)
            @if ($center->status == 0)
                <tr class="hover:bg-base-200 transition-colors">
                    <td class="px-4 py-2 font-medium">{{ $center->name }}</td>
                    <td class="px-4 py-2">{{ $center->address }}</td>
                    <td class="px-4 py-2">{{ $center->phone }}</td>
                    <td class="px-4 py-2">{{ $center->email }}</td>
                    <td class="px-4 py-2 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('center_show', $center) }}" class="btn btn-xs btn-info">Veure</a>
                            <form action="{{ route('center_activate', $center) }}" method="POST" style="display:inline;">
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