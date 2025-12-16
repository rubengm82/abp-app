<table class="table w-full table-xs table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Professional afectat</th>
            <th class="px-4 py-2 text-left">Registrat per</th>
            <th class="px-4 py-2 text-left">Derivat a</th>
            <th class="px-4 py-2 text-left">Descripció</th>
            <th class="px-4 py-2 text-left">Data d'obertura</th>
            <th class="px-4 py-2 text-left">Estat</th>
            <th class="px-4 py-2 text-right">Acció</th>
        </tr>
    </thead>
    <tbody>
        @foreach($hrIssues as $hrIssue)
            <tr class="hover:bg-base-300 transition-colors text-xs">
                <td class="px-4 py-2">
                    @if($hrIssue->affectedProfessional)
                        <p>{{ $hrIssue->affectedProfessional->name }} {{ $hrIssue->affectedProfessional->surname1 }}</p>
                    @else
                        <span class="text-base-content/50">No assignat</span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    @if($hrIssue->registeringProfessional)
                        {{ $hrIssue->registeringProfessional->name }} {{ $hrIssue->registeringProfessional->surname1 }}
                    @else
                        <span class="text-base-content/50">No assignat</span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    @if($hrIssue->referredToProfessional)
                        <p>{{ $hrIssue->referredToProfessional->name }} {{ $hrIssue->referredToProfessional->surname1 }}</p>
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
                <td class="px-4 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('hr_issue_show', $hrIssue->id) }}" class="btn btn-xs btn-info">Veure</a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- <div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $hrIssues->links('pagination::daisyui-pagination') }}
   </div>
</div> --}}

