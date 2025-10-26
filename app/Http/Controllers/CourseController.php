<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();

        return view("components.contents.courses.coursesList")
            ->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("components.contents.courses.courseForm");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Course::create([
            'training_center'     => $request->input('training_center'),
            'training_name'     => $request->input('training_name'),
            'forcem_code'       => $request->input('forcem_code'),
            'total_hours'       => $request->input('total_hours'),
            'type'              => $request->input('type'),
            'attendance_type'   => $request->input('attendance_type'),
            'workshop'          => $request->input('workshop'),
            'conference_day'    => $request->input('conference_day'),
            'congress'          => $request->input('congress'),
            'attendee'          => $request->input('attendee'),
            'start_date'        => $request->input('start_date'),
            'end_date'          => $request->input('end_date'),
        ]);

        return redirect()->route('course_form')->with('success', 'Curs afegit correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::findOrFail($id);
        return view("components.contents.courses.courseShow")->with('course', $course);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::findOrFail($id);

        return view('components.contents.courses.courseEdit')
            ->with('course', $course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //TODO: Consider adding validation in the request
        $course = Course::findOrFail($id);
        $course->update($request->all());
        
        return redirect()->route('courses_list')->with('success', 'Curs actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        
        return redirect()->route('courses_list')->with('success', 'Curs eliminat correctament!');
    }

    /**
     * Download CSV from resource in storage
     */
    public function downloadCSV()
    {
        $cursos = Course::all();

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "cursos_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');
            fputcsv($handle, [
            'ID',
            'Centre de Formació',
            'Codi FORCEM',
            'Hores totals',
            'Tipus de curs',
            'Modalitat',
            'Nom del curs',
            'Taller',
            'Dia de conferència',
            'Congrés',
            'Assistents',
            'Data d\'inici',
            'Data de finalització'
            ]);

        foreach ($cursos as $curs) {
        fputcsv($handle, [
                $curs->id,
                $curs->training_center,
                $curs->forcem_code,
                $curs->total_hours,
                $curs->type,
                $curs->attendance_type,
                $curs->training_name,
                $curs->workshop,
                $curs->conference_day,
                $curs->congress,
                $curs->attendee,
                $curs->start_date,
                $curs->end_date,
            ]);
        }

        // Close Pointer File
        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
