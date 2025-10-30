<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Professional;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mockery\Loader\EvalLoader;
use PhpParser\Node\Expr\Eval_;

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
    public function show(String $professionalEvaluated_id, String $professionalEvaluator_id, String $uuid)
    {
        $answers = Evaluation::where('evaluation_uuid', $uuid)->get();
        $professionalEvaluated = Professional::where('id', $professionalEvaluated_id)->get();
        $professionalEvaluator = Professional::where('id', $professionalEvaluator_id)->get();
        $questions = Quiz::all();
        
        // dd($evaluation);
        // dd($professionalEvaluated);

        return view("components.contents.professional.evaluations.professionalQuizShow")
            ->with([
                'answers' => $answers,
                'questions' => $questions,
                'professionalEvaluated' => $professionalEvaluated,
                'professionalEvaluator' => $professionalEvaluator,
            ]);
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

    /**
     * Download CSV for only one professional evaluated in a single quiz
     */
    public function downloadCSV_professional_evaluated(string $evaluation_uuid)
    {
        $answers = Evaluation::with(['evaluatedProfessional', 'evaluatorProfessional', 'question'])
            ->where('evaluation_uuid', $evaluation_uuid)
            ->get();

        if ($answers->isEmpty()) {
            return redirect()->back()->with('error', 'No s’ha trobat aquesta avaluació.');
        }

        $first = $answers->first(); // Tomamos info del evaluado/evaluador

        // FILE NAME
        $evaluatedName = Str::slug(
            trim(
                optional($first->evaluatedProfessional)->name . ' ' .
                optional($first->evaluatedProfessional)->surname1 . ' ' .
                optional($first->evaluatedProfessional)->surname2
            ),
            '_'
        );
        $evaluationDate = $first->created_at->format('d-m-Y_H-i-s');
        $filename = "avaluacio_{$evaluatedName}_{$evaluationDate}.csv";
        // END FILE NAME

        $handle = fopen($filename, 'w+');

        // Encabezados generales
        fputcsv($handle, ["Professional Avaluat:", optional($first->evaluatedProfessional)->name . ' ' . optional($first->evaluatedProfessional)->surname1 . ' ' . optional($first->evaluatedProfessional)->surname2]);
        fputcsv($handle, ["Professional Avaluador:", optional($first->evaluatorProfessional)->name . ' ' . optional($first->evaluatorProfessional)->surname1 . ' ' . optional($first->evaluatorProfessional)->surname2]);
        fputcsv($handle, ["Data de l'avaluació:", $first->created_at->format('d/m/Y H:i:s')]);

        // Línea vacía para separar del listado de preguntas
        fputcsv($handle, []);

        // Cabecera de las preguntas
        fputcsv($handle, ['Pregunta', 'Resposta']);

        // Mapa de respuestas
        $answerTextMap = [
            0 => 'Gens d\'acord',
            1 => 'Poc d\'acord',
            2 => 'Bastant d\'acord',
            3 => 'Molt d\'acord',
        ];

        // Preguntas y respuestas
        foreach ($answers as $answer) {
            fputcsv($handle, [
                $answer->question->question ?? 'Pregunta sense nom',
                $answerTextMap[$answer->answer] ?? $answer->answer,
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

}
