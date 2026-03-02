<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Avaluat</th>
            <th class="px-4 py-2 text-left">Avaluador</th>
            <th class="px-4 py-2 text-left">Data de l'Avaluació</th>
            <th class="px-4 py-2 text-right">Resposta Mitjana</th>
        </tr>
    </thead>
    <tbody>
        @foreach($groupedEvaluations as $group)
            @php $first = $group->group->first(); @endphp
            <tr class="hover:bg-base-300 transition-colors text-xs cursor-pointer" data-href="{{ route('professional_evaluation_quiz_show', [$first->evaluated_professional_id, $first->evaluator_professional_id, $first->evaluation_uuid]) }}" role="link" tabindex="0">
                <td class="px-4 py-2">
                    @php $evaluated = $first->evaluatedProfessional; @endphp
                    @if($evaluated)
                        <a href="{{ route('professional_show', $evaluated->id) }}" class="link link-hover text-info link-info">
                            {{ $evaluated->name }} {{ $evaluated->surname1 }} {{ $evaluated->surname2 }}
                        </a>
                    @else
                        —
                    @endif
                </td>

                <td class="px-4 py-2">
                    @php $evaluator = $first->evaluatorProfessional; @endphp
                    @if($evaluator)
                        <a href="{{ route('professional_show', $evaluator->id) }}" class="link link-hover text-info link-info">
                            {{ $evaluator->name }} {{ $evaluator->surname1 }} {{ $evaluator->surname2 }}
                        </a>
                    @else
                        —
                    @endif
                </td>

                <td class="px-4 py-2">
                    {{ $first->created_at->toDateTimeString() }}
                </td>

               <td class="px-4 py-2 text-right font-bold text-base-content">
                    @if (($group->averagePercentage ?? 0) <= 25)
                        Gens d'acord
                    @elseif (($group->averagePercentage ?? 0) <= 50)
                        Poc d'acord
                    @elseif (($group->averagePercentage ?? 0) <= 75)
                        Bastant d'acord
                    @else
                        Molt d'acord
                    @endif
                </td>
            </tr>
        @endforeach

    </tbody>
</table>

{{-- <div class="pagination">
    <div class="mt-6 flex justify-center">
       {{ $evaluations->links('pagination::daisyui-pagination') }}
   </div>
</div> --}}