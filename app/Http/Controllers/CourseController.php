<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Professional;
use Illuminate\Http\Request;
use App\Models\NotesComponent;
use App\Models\DocumentComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\mainlog;

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
        $course = Course::with([])->findOrFail($id);
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

    //// DOCUMENTS ////
    // Upload Document to server
    public function course_document_add(Request $request, Course $course)
    {
        $request->validate([
            'file' => 'required|file|max:10240', 
        ]);

        $file = $request->file('file');

        // File name: original_name + fecha
        $timestamp = now()->format('Ymd_His');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $originalName . '_' . $timestamp . '.' . $extension;

        $filePath = $file->storeAs('documents/courses', $fileName, 'public');

        $course->documents()->create([
            'file_name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by_professional_id' => Auth::user()->id,
        ]);

        return back()->with('success', 'Document pujat correctament!');
    }


    // Download Document to server
    public function course_document_download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (file_exists($path)) {
            return response()->download($path, $document->original_name);
        }

        return back()->with('error', 'El document no existeix.');
    }

    // Delete Document to server
    public function course_document_delete(DocumentComponent $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document eliminat correctament!');
    }


    //// NOTES ////
    public function course_note_add(Request $request, Course $course)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $course->notes()->create([
            'notes' => $request->input('notes'),
            'created_by_professional_id' => Auth::id()
        ]);

        return redirect()->route('course_show', $course->id . '#notes-section')
                         ->with('success', 'Nota afegida correctament!');
    }

    public function course_note_update(Request $request, NotesComponent $note)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $note->update(['notes' => $request->input('notes')]);

        return redirect()->route('course_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota actualitzada correctament!');
    }

    public function course_note_delete(NotesComponent $note)
    {
        $note->delete();

        return redirect()->route('course_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota eliminada correctament!');
    }

    //// PROFESSIONAL ASSIGNMENTS ////
    /**
     * Show the form to assign professionals to a course
     */
    public function assignProfessionals(Course $course)
    {
        // Get all active professionals
        $allProfessionals = Professional::where('status', 1)->orderBy('name')->get();
        
        // Get assigned professional IDs
        // pluck(): method that extracts a single column
        $assignedProfessionalIds = $course->assignments->pluck('professional_id')->toArray();
        
        // Separate assigned and unassigned professionals
        $unassignedProfessionals = $allProfessionals->whereNotIn('id', $assignedProfessionalIds);
        $assignedProfessionals = $allProfessionals->whereIn('id', $assignedProfessionalIds);
        
        return view('components.contents.courses.courseAssignProfessionals', [
            'course' => $course,
            'unassignedProfessionals' => $unassignedProfessionals,
            'assignedProfessionals' => $assignedProfessionals
        ]);
    }

    /**
     * Update professional assignments for a course
     */
    public function updateProfessionalAssignments(Request $request, Course $course)
    {
        mainlog::log("Empieza el método updateProfessionalAssignments en Course");
        mainlog::log("Request: ". json_encode($request->professional_ids));

        // Validate the request
        $request->validate([
            'professional_ids' => 'nullable|array',
            'professional_ids.*' => 'exists:professionals,id'
        ]);

        // Get the professional IDs from the request
        $professionalIds = $request->input('professional_ids', []);

        // Delete existing assignments
        $course->assignments()->delete();

        // Create new assignments
        foreach ($professionalIds as $professionalId) {
            $course->assignments()->create([
                'professional_id' => $professionalId,
                'certificate' => 'Pendent'
            ]);
        }

        return redirect()->route('course_show', $course)
                         ->with('success', 'Professionals assignats correctament!');
    }

}
