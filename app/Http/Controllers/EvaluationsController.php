<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Professional;
use App\Models\Quiz;
use Illuminate\Http\Request;

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
        $groupedEvaluations = $evaluations->groupBy('evaluated_professional_id');

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
        ]);

        foreach ($request->questions as $quiz_id => $answer_value) {
            Evaluation::create([
                'evaluated_professional_id' => $request->input('avaluat'),
                'evaluator_professional_id' => $request->input('evaluador'),
                'question_id' => $quiz_id,
                'answer' => $answer_value,
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
            'evaluated_id' => 'required|integer',
            'evaluator_id' => 'required|integer',
        ]);

        $evaluatedId = $request->input('evaluated_id');
        $evaluatorId = $request->input('evaluator_id');

        // Borrar todas las evaluaciones de ese par evaluador/avaluat
        Evaluation::where('evaluated_professional_id', $evaluatedId)
                  ->where('evaluator_professional_id', $evaluatorId)
                  ->delete();

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
        $evaluations = Evaluation::with(['evaluatedProfessional', 'evaluatorProfessional'])->get();

        // Agrupar por evaluado para evitar filas repetidas
        $grouped = $evaluations->groupBy(fn($item) => $item->evaluatedProfessional?->id);

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
                $first->created_at->toDateString(),
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

}
