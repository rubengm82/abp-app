<table class="table w-full table-xs table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">Avaluat</th>
            <th class="px-4 py-2 text-left">Avaluador</th>
            <th class="px-4 py-2 text-left">Data de l'Avaluació</th>
            <th class="px-4 py-2 text-right">Resposta Mitjana</th>
            <th class="px-4 py-2 text-right">Acció</th>
        </tr>
    </thead>
    <tbody>
        @foreach($groupedEvaluations as $group)
            <tr class="hover:bg-base-300 transition-colors">
                <td class="px-4 py-2">
                    {{ optional($group->group->first()->evaluatedProfessional)->name }}
                    {{ optional($group->group->first()->evaluatedProfessional)->surname1 }}
                    {{ optional($group->group->first()->evaluatedProfessional)->surname2 }}
                </td>

                <td class="px-4 py-2">
                    {{ optional($group->group->first()->evaluatorProfessional)->name }}
                    {{ optional($group->group->first()->evaluatorProfessional)->surname1 }}
                    {{ optional($group->group->first()->evaluatorProfessional)->surname2 }}
                </td>

                <td class="px-4 py-2">
                    {{ $group->group->first()->created_at->toDateTimeString() }}
                </td>

               <td class="px-4 py-2 text-right font-semibold text-base-content">
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

                <td class="px-4 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('professional_evaluation_quiz_show', [
                            $group->group->first()->evaluated_professional_id,
                            $group->group->first()->evaluator_professional_id,
                            $group->group->first()->evaluation_uuid
                        ]) }}" class="btn btn-xs btn-info">Veure</a>
                    </div>
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