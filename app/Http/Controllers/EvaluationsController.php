<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\EvaluationObservation;
use App\Models\Professional;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class EvaluationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Evaluation::with(['evaluatedProfessional', 'evaluatorProfessional']);

        if ($search = $request->get('search')) {
            $query
                ->whereHas('evaluatedProfessional', function ($q) use ($search) {
                    $q->where(function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('surname1', 'like', "%{$search}%")
                            ->orWhere('surname2', 'like', "%{$search}%");
                    });
                })
                ->orWhereHas('evaluatorProfessional', function ($q) use ($search) {
                    $q->where(function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('surname1', 'like', "%{$search}%")
                            ->orWhere('surname2', 'like', "%{$search}%");
                    });
                });
        }

        $evaluations = $query->get();

        $groupedEvaluations = $evaluations->groupBy('evaluation_uuid');

        $questions = Quiz::all();

        $groupedEvaluations = $groupedEvaluations->map(function ($group) use ($questions) {
            return (object)[
                'group' => $group,
                'averagePercentage' => $this->calculateAveragePercentage($questions, $group),
            ];
        });

        $sortedGroups = $groupedEvaluations->sortByDesc(fn($item) => $item->group->first()->created_at);

        $page = $request->get('page', 1);
        $perPage = 10;

        $pagedGroups = $sortedGroups->forPage($page, $perPage);

        $pagination = new LengthAwarePaginator(
            $pagedGroups,
            $sortedGroups->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        if ($request->ajax()) {
            return view('components.contents.professional.evaluations.tables.professionalEvaluationsListTable', [
                'groupedEvaluations' => $pagedGroups,
                'evaluations' => $pagination,
            ])->render();
        }

        return view('components.contents.professional.evaluations.professionalEvaluationsList', [
            'groupedEvaluations' => $pagedGroups,
            'evaluations' => $pagination,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $questions = Quiz::all();
        $professionals = Professional::where('status', 1)->get();

        // Calcular la media de respuestas por cada pregunta
        $evaluations = Evaluation::all();

        $questionAverages = [];

        // Avg per question
        foreach ($questions as $question) {
            $answers = $evaluations->where('question_id', $question->id);
            if ($answers->count() > 0) {
                $avg = round(
                $answers->avg(function ($evaluation) {
                    return match ($evaluation->answer) {
                        0 => 25,
                        1 => 50,
                        2 => 75,
                        3 => 100,
                        default => 0
                    };
                }),
                2
            );
            } else {
                $avg = 0;
            }

            $questionAverages[$question->id] = $avg;
        }

        return view("components.contents.professional.evaluations.professionalQuiz", [
            'questions' => $questions,
            'professionals' => $professionals,
            'questionAverages' => $questionAverages,
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
            'observation' => 'nullable|string|max:5000',
        ]);

        // Check that you are not evaluating yourself
        if ($request->input('avaluat') == $request->input('evaluador')) {
            return redirect()->back()
                ->withInput()
                ->with(['error' => 'No es pot avaluar a un mateix.']);
        }

        
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

        // Create or update observation if provided
        if ($request->has('observation') && !empty($request->input('observation'))) {
            EvaluationObservation::updateOrCreate(
                ['evaluation_uuid' => $uuid_pre_generated],
                ['observation' => $request->input('observation')]
            );
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

        // Get observation for this evaluation UUID
        $observation = EvaluationObservation::where('evaluation_uuid', $uuid)->first();

        $averagePercentage = $this->calculateAveragePercentage($questions, $answers);

        return view("components.contents.professional.evaluations.professionalQuizShow")
            ->with([
                'answers' => $answers,
                'questions' => $questions,
                'professionalEvaluated' => $professionalEvaluated,
                'professionalEvaluator' => $professionalEvaluator,
                'averagePercentage' => $averagePercentage,
                'observation' => $observation,
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

        // Delete all evaluations of that evaluator/evaluated pair
        Evaluation::where('evaluation_uuid', $uuid)->delete();

        // Delete observation if exists
        EvaluationObservation::where('evaluation_uuid', $uuid)->delete();

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
        $questions = Quiz::all();
        $evaluations = Evaluation::with(['evaluatedProfessional', 'evaluatorProfessional'])
            ->get()
            ->sortByDesc('created_at');

        $grouped = $evaluations->groupBy(fn($item) => $item->evaluation_uuid);

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "avaluacions_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');

        fputcsv($handle, [
            'Avaluat',
            'Avaluador',
            'Data de Creació',
            'Resposta mitjana'
        ]);

        foreach ($grouped as $evaluatedId => $group) {
            $first = $group->first();

            $averagePercentage = $this->calculateAveragePercentage($questions, $group);

            // Convertir porcentaje a texto
            if ($averagePercentage <= 25) {
                $averageText = "Gens d'acord";
            } elseif ($averagePercentage <= 50) {
                $averageText = "Poc d'acord";
            } elseif ($averagePercentage <= 75) {
                $averageText = "Bastant d'acord";
            } else {
                $averageText = "Molt d'acord";
            }

            fputcsv($handle, [
                optional($first->evaluatedProfessional)->name . ' ' .
                optional($first->evaluatedProfessional)->surname1 . ' ' .
                optional($first->evaluatedProfessional)->surname2,
                optional($first->evaluatorProfessional)->name . ' ' .
                optional($first->evaluatorProfessional)->surname1 . ' ' .
                optional($first->evaluatorProfessional)->surname2,
                $first->created_at->format('d/m/Y H:i:s'),
                $averageText
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

        $first = $answers->first();
        $questions = Quiz::all();

        $averagePercentage = $this->calculateAveragePercentage($questions, $answers);

        if ($averagePercentage <= 25) {
            $averageText = "Gens d'acord";
        } elseif ($averagePercentage <= 50) {
            $averageText = "Poc d'acord";
        } elseif ($averagePercentage <= 75) {
            $averageText = "Bastant d'acord";
        } else {
            $averageText = "Molt d'acord";
        }

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

        $handle = fopen($filename, 'w+');

        fputcsv($handle, ["Professional Avaluat:", optional($first->evaluatedProfessional)->name . ' ' . optional($first->evaluatedProfessional)->surname1 . ' ' . optional($first->evaluatedProfessional)->surname2]);
        fputcsv($handle, ["Professional Avaluador:", optional($first->evaluatorProfessional)->name . ' ' . optional($first->evaluatorProfessional)->surname1 . ' ' . optional($first->evaluatorProfessional)->surname2]);
        fputcsv($handle, ["Data de l'avaluació:", $first->created_at->format('d/m/Y H:i:s')]);
        
        fputcsv($handle, ["Resposta mitjana:", $averageText]);

        fputcsv($handle, []);

        fputcsv($handle, ['Pregunta', 'Resposta']);

        $answerTextMap = [
            0 => 'Gens d\'acord',
            1 => 'Poc d\'acord',
            2 => 'Bastant d\'acord',
            3 => 'Molt d\'acord',
        ];

        foreach ($answers as $answer) {
            fputcsv($handle, [
                $answer->question->question ?? 'Pregunta sense nom',
                $answerTextMap[$answer->answer] ?? $answer->answer,
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
    
    // Calculate average percentage from answers
    protected function calculateAveragePercentage($questions, $answers)
    {
        $averagePercentage = 0;

        $totalQuestions = $questions->count();
        if ($totalQuestions > 0) {
            $sumPercentage = 0;

            foreach ($questions as $question) {
                $answer = $answers->firstWhere('question_id', $question->id);
                if ($answer) {
                    switch ($answer->answer) {
                        case 0:
                            $sumPercentage += 25;
                            break;
                        case 1:
                            $sumPercentage += 50;
                            break;
                        case 2:
                            $sumPercentage += 75;
                            break;
                        case 3:
                            $sumPercentage += 100;
                            break;
                    }
                }
            }

            $averagePercentage = round($sumPercentage / $totalQuestions, 2);
        }

        return $averagePercentage;
    }

    // Ca
    protected function calculateAverageByQuestion()
    {
        $questions = Quiz::all();
        $evaluations = Evaluation::all();

        $averagesByQuestion = [];

        foreach ($questions as $question) {
            $answers = $evaluations->where('question_id', $question->id);

            $sum = 0;
            $count = $answers->count();

            if ($count > 0) {
                foreach ($answers as $evaluation) {
                    if ($evaluation->answer == 0) $sum += 25;
                    elseif ($evaluation->answer == 1) $sum += 50;
                    elseif ($evaluation->answer == 2) $sum += 75;
                    elseif ($evaluation->answer == 3) $sum += 100;
                }

                $average = round($sum / $count, 2);
            } else {
                $average = 0;
            }

            $averagesByQuestion[] = [
                'question' => $question->question,
                'average' => $average,
            ];
        }

        return $averagesByQuestion;
    }

}
