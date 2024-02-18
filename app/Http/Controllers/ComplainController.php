<?php

namespace App\Http\Controllers;

use App\Models\Complain;
use Illuminate\Http\Request;
use App\DataTables\ComplainDataTable;
use App\DataTables\PatientComplainDataTable;
use App\DataTables\CaretakerComplainDataTable;

class ComplainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ComplainDataTable $dataTable)
    {
        return $dataTable->render('complains.index');
    }

    public function patientIndex(PatientComplainDataTable $dataTable)
    {
        return $dataTable->render('complains.patient_index');
    }

    public function caretakerIndex(CaretakerComplainDataTable $dataTable)
    {
        return $dataTable->render('complains.caretaker_index');
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
    public function show($id)
    {
        $complain = Complain::find($id);

        return view('complains.show', compact('complain'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complain $complain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complain $complain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complain $complain)
    {
        //
    }
}
