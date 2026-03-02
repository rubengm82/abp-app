@if($centers->isEmpty() && ($searchPerformed ?? false))
    <div class="text-center py-8 text-base-content/70">No s'han trobat resultats. Proveu amb altres paraules.</div>
@else
<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Nom</th>
            <th class="px-4 py-2 text-left">Adreça</th>
            <th class="px-4 py-2 text-left whitespace-nowrap min-w-[7rem]">Telèfon</th>
            <th class="px-4 py-2 text-left">Email</th>
            @if($isDeactivated)
                <th class="px-4 py-2 text-right">Accions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($centers as $center)
            <tr class="hover:bg-base-300 transition-colors text-xs {{ !$isDeactivated ? 'cursor-pointer' : '' }}" @if(!$isDeactivated) data-href="{{ route('center_show', $center) }}" role="link" tabindex="0" @endif>
                <td class="px-4 py-2 font-medium">{{ $center->name }}</td>
                <td class="px-4 py-2">{{ $center->address }}</td>
                <td class="px-4 py-2 whitespace-nowrap">{{ $center->phone }}</td>
                <td class="px-4 py-2">{{ $center->email }}</td>
                @if($isDeactivated)
                    <td class="px-4 py-2 text-right">
                        <div class="flex justify-end gap-2">
                            <form action="{{ route('center_activate', $center) }}" method="POST" style="display:inline;">
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