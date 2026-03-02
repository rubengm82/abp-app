@if($externalContacts->isEmpty() && ($searchPerformed ?? false))
    <div class="text-center py-8 text-base-content/70">No s'han trobat resultats. Proveu amb altres paraules.</div>
@else
<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Tipus</th>
            <th class="px-4 py-2 text-left">Empresa</th>
            <th class="px-4 py-2 text-left">Departament</th>
            <th class="px-4 py-2 text-left">Responsable</th>
            <th class="px-4 py-2 text-left whitespace-nowrap min-w-[7rem]">Telèfon</th>
            <th class="px-4 py-2 text-left">Correu</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($externalContacts as $externalContact)
            <tr class="hover:bg-base-300 transition-colors text-xs cursor-pointer" data-href="{{ route('externalcontact_show', $externalContact) }}" role="link" tabindex="0">
                <td class="px-4 py-2">{{ $externalContact->external_contact_type ?? '' }}</td>
                <td class="px-4 py-2 font-medium">{{ $externalContact->company ?? '' }}</td>
                <td class="px-4 py-2">{{ $externalContact->department ?? '' }}</td>
                <td class="px-4 py-2">
                    @if($externalContact->name || $externalContact->surname)
                        {{ trim(($externalContact->name ?? '') . ' ' . ($externalContact->surname ?? '')) }}
                    @else
                        <span class="text-base-content/50"></span>
                    @endif
                </td>
                <td class="px-4 py-2 whitespace-nowrap">{{ $externalContact->phone ?? '' }}</td>
                <td class="px-4 py-2">{{ $externalContact->email ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- <div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $externalContacts->links('pagination::daisyui-pagination') }}
   </div>
</div> --}}

