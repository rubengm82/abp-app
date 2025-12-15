<table class="table w-full table-xs table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">Tipus</th>
            <th class="px-4 py-2 text-left">Data</th>
            <th class="px-4 py-2 text-left">Professional afectat</th>
            <th class="px-4 py-2 text-left">Registrat per</th>
            <th class="px-4 py-2 text-left">Context</th>
            <th class="px-4 py-2 text-left">Descripció</th>
            <th class="px-4 py-2 text-right">Acció</th>
        </tr>
    </thead>
    <tbody>
        @foreach($accidents as $accident)
            <tr class="hover:bg-base-300 transition-colors">
                <td class="px-4 py-2">
                    <span class="badge badge-dash whitespace-normal text-center {{ $accident->type === 'Baixa Finalitzada' ? 'badge-success' : ($accident->type === 'Con baixa' ? 'badge-warning' : 'badge-info') }}">
                        {{ $accident->type }}
                    </span>
                </td>
                <td class="px-4 py-2">{{ $accident->date->format('d/m/Y') }}</td>
                <td class="px-4 py-2">
                    @if($accident->affectedProfessional)
                        <p>{{ $accident->affectedProfessional->name }} {{ $accident->affectedProfessional->surname1 }} {{ $accident->affectedProfessional->surname2 }}</p>
                    @else
                        <span class="text-base-content/50">No assignat</span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    @if($accident->createdByProfessional)
                        {{ $accident->createdByProfessional->name }} {{ $accident->createdByProfessional->surname1 }}
                    @else
                        <span class="text-base-content/50">No assignat</span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    <div class="max-w-xs truncate" title="{{ $accident->context }}">
                        {{ $accident->context ? Str::limit($accident->context, 50) : '-' }}
                    </div>
                </td>
                <td class="px-4 py-2">
                    <div class="max-w-xs truncate" title="{{ $accident->description }}">
                        {{ $accident->description ? Str::limit($accident->description, 50) : '-' }}
                    </div>
                </td>
                <td class="px-4 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('professional_accident_show', $accident->id) }}" class="btn btn-xs btn-info">Veure</a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $accidents->links('pagination::daisyui-pagination') }}
   </div>
</div>

