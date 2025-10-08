<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centers = Center::all();
        return view("components.contents.center.centersList")->with('centers', $centers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("components.contents.center.centerForm");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // echo "Aquí está guardando con un insert el formulario!";
        // echo "<br>";
        // echo $request->input('name');
        // echo "<br>";
        // echo $request->input('address');
        // echo "<br>";
        // echo $request->input('phone');
        // echo "<br>";
        // echo $request->input('email');

        //echo "Centre afegit!";

        $status_actived = '1';

        Center::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'status' => $status_actived,
        ]);
        return redirect()->route('center_form')->with('success_added', 'Centre afegit correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // return view("components.contents.center.centerEdit");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    /* *********** */
    /* OWN METHODS */
    /* *********** */
    
    /**
     * Display a listing of the resource.
     */
    public function index_desactivatedCenters()
    {
        $centers = Center::all();
        return view("components.contents.center.centersDesactivatedList")->with('centers', $centers);
    }

    /**
     * Activate Status the specified resource in storage.
     */
    public function activateStatus(Request $request, Center $center)
    {
        $center->status = 1;
        $center->save();
        
        return redirect()->route('centers_desactivated_list')->with('success_activated', 'Centre activat correctament!');;;
    }
    /**
     * Desactivate Status the specified resource in storage.
     */
    public function desactivateStatus(Request $request, Center $center)
    {
        $center->update(['status' => 0]);

        $center->status = 0;
        $center->save();
        
        return redirect()->route('centers_list')->with('success_desactivated', 'Centre desactivat correctament!');;
    }

}
