<table class="table w-full table-xs table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">Tipus</th>
            <th class="px-4 py-2 text-left">Empresa</th>
            <th class="px-4 py-2 text-left">Departament</th>
            <th class="px-4 py-2 text-left">Responsable</th>
            <th class="px-4 py-2 text-left">Telèfon</th>
            <th class="px-4 py-2 text-left">Correu</th>
            <th class="px-4 py-2 text-right">Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($externalContacts as $externalContact)
            <tr class="hover:bg-base-300 transition-colors">
                <td class="px-4 py-2">{{ $externalContact->external_contact_type ?? '-' }}</td>
                <td class="px-4 py-2 font-medium">{{ $externalContact->company ?? '-' }}</td>
                <td class="px-4 py-2">{{ $externalContact->department ?? '-' }}</td>
                <td class="px-4 py-2">
                    @if($externalContact->name || $externalContact->surname)
                        {{ trim(($externalContact->name ?? '') . ' ' . ($externalContact->surname ?? '')) }}
                    @else
                        <span class="text-base-content/50"></span>
                    @endif
                </td>
                <td class="px-4 py-2">{{ $externalContact->phone ?? '-' }}</td>
                <td class="px-4 py-2">{{ $externalContact->email ?? '-' }}</td>
                <td class="px-4 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('externalcontact_show', $externalContact) }}" class="btn btn-xs btn-info">Veure</a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $externalContacts->links('pagination::daisyui-pagination') }}
   </div>
</div>

