<table class="table w-full table-xs table-zebra table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">ID</th>
            <th class="px-4 py-2 text-left">Centre</th>
            <th class="px-4 py-2 text-left">Codi</th>
            <th class="px-4 py-2 text-left">Nom</th>
            <th class="px-4 py-2 text-left">Primer cognom</th>
            <th class="px-4 py-2 text-left">Segon cognom</th>
            <th class="px-4 py-2 text-left">DNI</th>
            <th class="px-4 py-2 text-left">Adreça</th>
            <th class="px-4 py-2 text-left">Rol</th>
            <th class="px-4 py-2 text-left">Telèfon</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Estat</th>
            <th class="px-4 py-2 text-right">Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($professionals as $professional)
            @if ($professional->status == 0)
                <tr class="hover:bg-base-200 transition-colors">
                    <td class="px-4 py-2">{{ $professional->id }}</td>
                    <td class="px-4 py-2">
                        @if($professional->center)
                            <a href="{{ route('center_show', $professional->center->id) }}" 
                                class="link link-hover link-info">
                                {{ $professional->center->name }}
                            </a>
                        @else
                            <span class="text-base-content/50">No assignat</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $professional->key_code }}</td>
                    <td class="px-4 py-2">{{ $professional->name }}</td>
                    <td class="px-4 py-2">{{ $professional->surname1 }}</td>
                    <td class="px-4 py-2">{{ $professional->surname2 }}</td>
                    <td class="px-4 py-2">{{ $professional->dni }}</td>
                    <td class="px-4 py-2">{{ $professional->address }}</td>
                    <td class="px-4 py-2">{{ $professional->role }}</td>
                    <td class="px-4 py-2">{{ $professional->phone }}</td>
                    <td class="px-4 py-2">{{ $professional->email }}</td>
                    <td class="px-4 py-2">
                        <span class="badge badge-dash h-auto whitespace-normal text-center {{ $professional->employment_status === 'No Contractat' ? 'badge-success' : 'badge-warning' }}">
                            {{ $professional->employment_status }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('professional_show', $professional->id) }}" class="btn btn-xs btn-info">Veure</a>
                            <form action="{{ route('professional_activate', $professional->id) }}" method="POST" style="display:inline;">
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