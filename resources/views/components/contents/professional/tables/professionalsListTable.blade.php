<table class="table w-full table-xs table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">Nom</th>
            <th class="px-4 py-2 text-left">Primer cognom</th>
            <th class="px-4 py-2 text-left">Segon cognom</th>
            <th class="px-4 py-2 text-left">Taquilla</th>
            <th class="px-4 py-2 text-left">DNI</th>
            <th class="px-4 py-2 text-left">Adreça</th>
            <th class="px-4 py-2 text-left">Rol</th>
            <th class="px-4 py-2 text-left">Telèfon</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Estat</th>
            <th class="px-4 py-2 text-right">Acció</th>
        </tr>
    </thead>
    <tbody>
        @foreach($professionals as $professional)
            @if($professional->status == 1)
                <tr class="hover:bg-base-300 transition-colors">
                    <td class="px-4 py-2">{{ $professional->name }}</td>
                    <td class="px-4 py-2">{{ $professional->surname1 }}</td>
                    <td class="px-4 py-2">{{ $professional->surname2 }}</td>
                    <td class="px-4 py-2 font-mono">{{ $professional->locker_num }}</td>
                    <td class="px-4 py-2">{{ $professional->dni }}</td>
                    <td class="px-4 py-2">{{ $professional->address }}</td>
                    <td class="px-4 py-2">{{ $professional->role }}</td>
                    <td class="px-4 py-2">{{ $professional->phone }}</td>
                    <td class="px-4 py-2">{{ $professional->email }}</td>
                    <td class="px-4 py-2">
                        <span class="badge badge-dash whitespace-normal text-center {{ $professional->employment_status === 'Actiu' ? 'badge-success' : 'badge-warning' }}">
                            {{ $professional->employment_status }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('professional_show', $professional->id) }}" class="btn btn-xs btn-info">Veure</a>
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

<div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $professionals->links('pagination::daisyui-pagination') }}
   </div>
</div>