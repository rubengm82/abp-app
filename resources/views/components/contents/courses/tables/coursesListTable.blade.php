@if($courses->isEmpty() && ($searchPerformed ?? false))
    <div class="text-center py-8 text-base-content/70">No s'han trobat resultats. Proveu amb altres paraules.</div>
@else
<table class="table w-full table-md table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-bold">
            <th class="px-4 py-2 text-left">Nom del curs</th>
            <th class="px-4 py-2 text-left">Centre de Formació</th>
            <th class="px-4 py-2 text-left">Codi FORCEM</th>
            <th class="px-4 py-2 text-left">Modalitat</th>
            <th class="px-4 py-2 text-left">Data d'inici</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courses as $course)
            <tr class="hover:bg-base-300 transition-colors text-xs cursor-pointer" data-href="{{ route('course_show', $course) }}" role="link" tabindex="0">
                <td class="px-4 py-2 font-medium">{{ $course->training_name ? Str::limit($course->training_name, 30) : 'No especificat' }}</td>
                <td class="px-4 py-2">{{ $course->training_center ? Str::limit($course->training_center, 25) : 'No especificat' }}</td>
                <td class="px-4 py-2">{{ $course->forcem_code ? Str::limit($course->forcem_code, 15) : 'No especificat' }}</td>
                <td class="px-4 py-2">{{ $course->attendance_type ?: 'No especificat' }}</td>
                <td class="px-4 py-2">{{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('d/m/Y') : 'No especificat' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif