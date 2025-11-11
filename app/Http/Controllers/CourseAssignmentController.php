<?php

namespace App\Http\Controllers;

use App\Models\CourseAssignment;
use Illuminate\Http\Request;

class CourseAssignmentController extends Controller
{
    public function updateCertificate(Request $request, string $id)
    {
        $request->validate([
            'certificate' => 'required|in:Pendent,Entregat',
        ]);

        $courseAssignment = CourseAssignment::findOrFail($id);

        $courseAssignment->update([
            'certificate' => $request->input('certificate'),
        ]);

        return back()->with('success', 'Estat del certificat actualitzat correctament!');
    }
}