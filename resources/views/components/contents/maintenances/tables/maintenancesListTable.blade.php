<table class="table w-full table-xs table-hover text-sm">
    <thead>
        <tr class="bg-base-300 text-base-content font-semibold">
            <th class="px-4 py-2 text-left">Nom del curs</th>
            <th class="px-4 py-2 text-left">Centre de Formació</th>
            <th class="px-4 py-2 text-left">Codi FORCEM</th>
            <th class="px-4 py-2 text-left">Modalitat</th>
            <th class="px-4 py-2 text-left">Data d'inici</th>
            <th class="px-4 py-2 text-right">Acció</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courses as $course)
            <tr class="hover:bg-base-300 transition-colors">
                {{-- <td class="px-4 py-2 font-medium">{{ Str::limit($course->training_name, 30) }}</td> --}}
                {{-- <td class="px-4 py-2">{{ Str::limit($course->training_center, 25) }}</td>
                <td class="px-4 py-2">{{ Str::limit($course->forcem_code, 15) }}</td>
                <td class="px-4 py-2">{{ $course->attendance_type ?? 'No especificada' }}</td>
                <td class="px-4 py-2">{{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('d/m/Y') : 'No especificada' }}</td> --}}
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td class="px-4 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        {{-- <a href="{{ route('course_show', $course) }}" class="btn btn-xs btn-info">Veure</a> --}}
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>