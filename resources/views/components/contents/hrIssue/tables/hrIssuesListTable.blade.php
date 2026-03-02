@if($hrIssues->isEmpty() && ($searchPerformed ?? false))
    <div class="text-center py-8 text-base-content/70">No s'han trobat resultats. Proveu amb altres paraules.</div>
@else
<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Professional afectat</th>
            <th class="px-4 py-2 text-left">Registrat per</th>
            <th class="px-4 py-2 text-left">Derivat a</th>
            <th class="px-4 py-2 text-left">Descripció</th>
            <th class="px-4 py-2 text-left">Data d'obertura</th>
            <th class="px-4 py-2 text-left">Estat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($hrIssues as $hrIssue)
            <tr class="hover:bg-base-300 transition-colors text-xs cursor-pointer" data-href="{{ route('hr_issue_show', $hrIssue->id) }}" role="link" tabindex="0">
                <td class="px-4 py-2">
                    @if($hrIssue->affectedProfessional)
                        <a href="{{ route('professional_show', $hrIssue->affectedProfessional->id) }}" class="link link-hover text-info link-info">
                            {{ $hrIssue->affectedProfessional->name }} {{ $hrIssue->affectedProfessional->surname1 }}
                        </a>
                    @else
                        <span class="text-base-content/50">No assignat</span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    @if($hrIssue->registeringProfessional)
                        <a href="{{ route('professional_show', $hrIssue->registeringProfessional->id) }}" class="link link-hover text-info link-info">
                            {{ $hrIssue->registeringProfessional->name }} {{ $hrIssue->registeringProfessional->surname1 }}
                        </a>
                    @else
                        <span class="text-base-content/50">No assignat</span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    @if($hrIssue->referredToProfessional)
                        <a href="{{ route('professional_show', $hrIssue->referredToProfessional->id) }}" class="link link-hover text-info link-info">
                            {{ $hrIssue->referredToProfessional->name }} {{ $hrIssue->referredToProfessional->surname1 }}
                        </a>
                    @else
                        <span class="text-base-content/50"></span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    <div class="max-w-xs truncate" title="{{ $hrIssue->description }}">
                        {{ Str::limit($hrIssue->description, 50) }}
                    </div>
                </td>
                <td class="px-4 py-2">{{ $hrIssue->opening_date->format('d/m/Y') }}</td>

                <td class="px-4 py-2">
                    <span class="badge badge-dash whitespace-nowrap text-center min-w-0 max-w-full truncate {{ $hrIssue->status === 'Tancat' ? 'badge-success' : 'badge-warning' }}">
                        {{ $hrIssue->status }}
                    </span>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- <div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $hrIssues->links('pagination::daisyui-pagination') }}
   </div>
</div> --}}

