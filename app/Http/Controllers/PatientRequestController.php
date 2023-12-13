<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PatientRequest;
use App\DataTables\PendingDepositDataTable;
use App\DataTables\PendingPaymentApproveDataTable;

class PatientRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PendingPaymentApproveDataTable $dataTable)
    {
        return $dataTable->render('patient_requests.index');
    }

    public function pendingDeposit(PendingDepositDataTable $dataTable)
    {
        return $dataTable->render('patient_requests.index_pending_deposit');
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
    public function show(PatientRequest $patientRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PatientRequest $patientRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PatientRequest $patientRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientRequest $patientRequest)
    {
        //
    }

    public function approve($id)
    {
        $patientRequest = PatientRequest::findOrFail($id);

        if($patientRequest)
            {
                $patientRequest->update([
                    'status' => 5, //paymet done
                ]);

                $patientRequest->patientrequeststatus()->create([
                    'status' => 5,
                    'date' => Carbon::now(),
                ]);
            }
        
        return redirect()->route('patient_requests.pendingapprove')->with('success','Approved');
    }

    public function reject($id)
    {
        $patientRequest = PatientRequest::findOrFail($id);

        if($patientRequest)
            {
                $patientRequest->update([
                    'status' => 7, //paymet done
                ]);

                $patientRequest->patientrequeststatus()->create([
                    'status' => 7,
                    'date' => Carbon::now(),
                ]);
            }
        
        return redirect()->route('patient_requests.pendingapprove')->with('success','Approved');
    }

    public function deposit($id)
    {
        $patientRequest = PatientRequest::findOrFail($id);

        if($patientRequest)
            {
                $patientRequest->update([
                    'status' => 6, //paymet done
                ]);

                $patientRequest->patientrequeststatus()->create([
                    'status' => 6,
                    'date' => Carbon::now(),
                ]);
            }
        
        return redirect()->route('patient_requests.pendingapprove')->with('success','Approved');
    }
}
