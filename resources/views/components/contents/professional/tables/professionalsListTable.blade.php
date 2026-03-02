<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Nom</th>
            <th class="px-4 py-2 text-left">Primer cognom</th>
            <th class="px-4 py-2 text-left">Segon cognom</th>
            <th class="px-4 py-2 text-left">DNI</th>
            <th class="px-4 py-2 text-left">Rol</th>
            <th class="px-4 py-2 text-left">Telèfon</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Estat</th>
            @if($isDeactivated)
                <th class="px-4 py-2 text-right">Accions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($professionals as $professional)
            <tr class="hover:bg-base-300 transition-colors text-xs {{ !$isDeactivated ? 'cursor-pointer' : '' }}" @if(!$isDeactivated) data-href="{{ route('professional_show', $professional->id) }}" role="link" tabindex="0" @endif>
                <td class="px-4 py-2">{{ $professional->name }}</td>
                <td class="px-4 py-2">{{ $professional->surname1 }}</td>
                <td class="px-4 py-2">{{ $professional->surname2 }}</td>
                <td class="px-4 py-2">{{ $professional->dni }}</td>
                <td class="px-4 py-2">{{ $professional->role }}</td>
                <td class="px-4 py-2">{{ $professional->phone }}</td>
                <td class="px-4 py-2">{{ $professional->email }}</td>
                <td class="px-4 py-2">
                    @php
                        $statusClasses = [
                            'Fixe' => 'badge-info',
                            'Eventual' => 'badge-success',
                            'Suplent habitual' => 'badge-warning',
                        ];
                        $badgeClass = $statusClasses[$professional->employment_status] ?? 'badge-error';
                    @endphp
                    <span class="badge badge-dash h-auto whitespace-nowrap text-center min-w-0 max-w-full truncate {{ $badgeClass }}">
                        {{ $professional->employment_status }}
                    </span>
                </td>
                @if($isDeactivated)
                    <td class="px-4 py-2 text-right">
                        <div class="flex justify-end gap-2">
                            <form action="{{ route('professional_activate', $professional->id) }}" method="POST" style="display:inline;">
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

{{-- <div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $professionals->links('pagination::daisyui-pagination') }}
   </div>
</div> --}}