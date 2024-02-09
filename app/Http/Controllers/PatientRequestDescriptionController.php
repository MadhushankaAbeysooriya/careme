<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientRequestDescription;
use App\DataTables\PatientRequestDescriptionDataTable;
use App\Http\Requests\StorePatientRequestDescriptionRequest;
use App\Http\Requests\UpdatePatientRequestDescriptionRequest;

class PatientRequestDescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PatientRequestDescriptionDataTable $dataTable)
    {
        return $dataTable->render('patient_request_descriptions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patient_request_descriptions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequestDescriptionRequest $request)
    {
        PatientRequestDescription::create($request->all());
        return redirect()->route('patient_request_descriptions.index')->with('success','Description Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $patientRequestDescription = PatientRequestDescription::find($id);

        return view('patient_request_descriptions.show',compact('patientRequestDescription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PatientRequestDescription $patientRequestDescription)
    {
        $patientRequestDescription = PatientRequestDescription::find($id);

        return view('patient_request_descriptions.edit',compact('patientRequestDescription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequestDescriptionRequest $request, PatientRequestDescription $patientRequestDescription)
    {
        $patientRequestDescription->update($request->toArray());
        return redirect()->route('patient_request_descriptions.index')->with('message', 'Description Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientRequestDescription $patientRequestDescription)
    {
        //
    }

    public function inactive($id){
        PatientRequestDescription::where('id',$id)->update(['status'=>'0']);
        return redirect()->route('patient_request_descriptions.index')->with( 'success','Description De-Activated');
    }

    public function activate($id){
        PatientRequestDescription::where('id',$id)->update(['status'=>'1']);
        return redirect()->route('patient_request_descriptions.index')->with( 'success','Description Activated');
    }
}
