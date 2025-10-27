<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Professional;
use Illuminate\Http\Request;

class EvaluationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $professionals = Professional::all()->keyBy('id');
        
        $evaluations = Evaluation::all();
        $groupedEvaluations = $evaluations->groupBy('evaluated_professional_id');

        return view("components.contents.professional.evaluations.professionalEvaluationsList")
            ->with([
                'evaluations' => $evaluations,
                'groupedEvaluations' => $groupedEvaluations,
                'professionals' => $professionals,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(Evaluation $evaluations)
    {
        //
    }
}
