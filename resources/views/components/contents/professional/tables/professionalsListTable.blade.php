<table class="table w-full table-xs {{ $isDeactivated ? 'table-zebra' : '' }} table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">Nom</th>
            <th class="px-4 py-2 text-left">Primer cognom</th>
            <th class="px-4 py-2 text-left">Segon cognom</th>
            <th class="px-4 py-2 text-left">DNI</th>
            <th class="px-4 py-2 text-left">Adreça</th>
            <th class="px-4 py-2 text-left">Rol</th>
            <th class="px-4 py-2 text-left">Telèfon</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Estat</th>
            <th class="px-4 py-2 text-right">{{ $isDeactivated ? 'Accions' : 'Acció' }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($professionals as $professional)
            <tr class="hover:bg-{{ $isDeactivated ? 'base-200' : 'base-300' }} transition-colors">
                <td class="px-4 py-2">{{ $professional->name }}</td>
                <td class="px-4 py-2">{{ $professional->surname1 }}</td>
                <td class="px-4 py-2">{{ $professional->surname2 }}</td>
                <td class="px-4 py-2">{{ $professional->dni }}</td>
                <td class="px-4 py-2">{{ $professional->address }}</td>
                <td class="px-4 py-2">{{ $professional->role }}</td>
                <td class="px-4 py-2">{{ $professional->phone }}</td>
                <td class="px-4 py-2">{{ $professional->email }}</td>
                <td class="px-4 py-2">
                    <span class="badge badge-dash h-auto whitespace-normal text-center {{ ($isDeactivated ? ($professional->employment_status === 'No Contractat') : ($professional->employment_status === 'Actiu')) ? 'badge-success' : 'badge-warning' }}">
                        {{ $professional->employment_status }}
                    </span>
                </td>
                <td class="px-4 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        @if(!$isDeactivated)
                            <a href="{{ route('professional_show', $professional->id) }}" class="btn btn-xs btn-info">Veure</a>
                        @endif
                        @if($isDeactivated)
                            <form action="{{ route('professional_activate', $professional->id) }}" method="POST" style="display:inline;">
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

<div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $professionals->links('pagination::daisyui-pagination') }}
   </div>
</div>