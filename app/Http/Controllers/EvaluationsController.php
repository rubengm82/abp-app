<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Professional;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EvaluationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all evaluations with their related professionals
        $evaluations = Evaluation::with(['evaluatedProfessional', 'evaluatorProfessional'])->get();

        // Sort by the surnames of the evaluated professional
        $evaluations = $evaluations->sortBy(function ($evaluation) {
            return $evaluation->evaluatedProfessional->surname1 . ' ' . $evaluation->evaluatedProfessional->surname2;
        });

        // Group evaluations by the evaluated professional
        $groupedEvaluations = $evaluations->groupBy('evaluation_uuid');

        return view("components.contents.professional.evaluations.professionalEvaluationsList")
            ->with([
                'evaluations' => $evaluations,
                'groupedEvaluations' => $groupedEvaluations,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $questions = Quiz::all();
        return view("components.contents.professional.evaluations.professionalQuiz",[
            'questions' => $questions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'avaluat' => 'required|exists:professionals,id',
            'evaluador' => 'required|exists:professionals,id',
            'questions.*' => 'required|integer|min:0|max:3',
            'evaluation_uuid' => 'nullable|uuid',
        ]);

        $uuid_pre_generated = Str::uuid()->toString();

        foreach ($request->questions as $quiz_id => $answer_value) {
            Evaluation::create([
                'evaluated_professional_id' => $request->input('avaluat'),
                'evaluator_professional_id' => $request->input('evaluador'),
                'question_id' => $quiz_id,
                'answer' => $answer_value,
                'evaluation_uuid' => $uuid_pre_generated,
            ]);
        }

        return redirect()->route('professional_evaluations_list')
            ->with('success', 'Evaluació afegida correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluation $evaluations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evaluation $evaluations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'evaluation_uuid' => 'required|uuid',
        ]);

        $uuid = $request->input('evaluation_uuid');

        // Borrar todas las evaluaciones de ese par evaluador/avaluat
        Evaluation::where('evaluation_uuid', $uuid)->delete();

        return redirect()->route('professional_evaluations_list')
                         ->with('success', 'Avaluació eliminada correctament.');
    }



    /* *********** */
    /* OWN METHODS */
    /* *********** */

    /**
     * Download CSV from resource in storage
     */
    public function downloadCSV()
    {
        $evaluations = Evaluation::with(['evaluatedProfessional', 'evaluatorProfessional'])
            ->get()
            ->sortBy([
                fn($a, $b) => strcmp(optional($a->evaluatedProfessional)->surname1, optional($b->evaluatedProfessional)->surname1),
                fn($a, $b) => strcmp(optional($a->evaluatedProfessional)->surname2, optional($b->evaluatedProfessional)->surname2),
        ]);

        // Agrupar por evaluado para evitar filas repetidas
        $grouped = $evaluations->groupBy(fn($item) => $item->evaluation_uuid);

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "avaluacions_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');

        // Cabecera
        fputcsv($handle, [
            'Avaluat',
            'Avaluador',
            'Data de Creació',
        ]);

        foreach ($grouped as $evaluatedId => $group) {
            $first = $group->first(); // tomamos la primera evaluación de cada evaluado
            fputcsv($handle, [
                optional($first->evaluatedProfessional)->name . ' ' .
                optional($first->evaluatedProfessional)->surname1 . ' ' .
                optional($first->evaluatedProfessional)->surname2,
                optional($first->evaluatorProfessional)->name . ' ' .
                optional($first->evaluatorProfessional)->surname1 . ' ' .
                optional($first->evaluatorProfessional)->surname2,
                $first->created_at->format('d/m/Y H:i:s'),
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

}
