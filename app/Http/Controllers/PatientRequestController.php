<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PatientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\DataTables\PendingDepositDataTable;
use App\DataTables\PendingServiceDataTable;
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

    public function pendingService(PendingServiceDataTable $dataTable)
    {
        return $dataTable->render('patient_requests.index_pending_service');
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

    public function approveView($id)
    {
        $patientRequest = PatientRequest::findOrFail($id);

        return view('patient_requests.approve_view',compact('patientRequest'));
    }

    public function approve($id)
    {
        $patientRequest = PatientRequest::findOrFail($id);

        if($patientRequest)
            {
                $patientRequest->update([
                    'status' => 5, //payment done
                ]);

                $patientRequestStatus = $patientRequest->patientrequeststatus()->create([
                    'status' => 5,
                    'date' => Carbon::now(),
                ]);

                $patientRequestStatus->patientrequestpaymentstatususer()->create([
                    'user_id' => Auth::user()->id,
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
                    'status' => 7, //payment reject
                ]);

                $patientRequestStatus = $patientRequest->patientrequeststatus()->create([
                    'status' => 7,
                    'date' => Carbon::now(),
                ]);

                $patientRequestStatus->patientrequestpaymentstatususer()->create([
                    'user_id' => Auth::user()->id,
                ]);
            }

        return redirect()->route('patient_requests.pendingapprove')->with('success','Approved');
    }

    public function depositView($id)
    {
        $patientRequest = PatientRequest::findOrFail($id);

        return view('patient_requests.deposit',compact('patientRequest'));
    }

    public function deposit(Request $request, $id)
    {
        $patientRequest = PatientRequest::findOrFail($id);

        try {

            $filepathDirectory = public_path('/upload/deposit/'.$id.'/');

            if (!File::isDirectory($filepathDirectory)) {
                File::makeDirectory($filepathDirectory, 0777, true, true);
            }

            $extfilepath = $request->file('filepath')->extension();
            $filefilepath = $id.'.'.$extfilepath;

            $request->file('filepath')->move($filepathDirectory, $filefilepath);

            if($patientRequest)
            {
                $patientRequest->update([
                    'status' => 6, //payment done
                ]);

                $patientRequest->patientrequeststatus()->create([
                    'status' => 6,
                    'date' => Carbon::now(),
                ]);

                $patientRequest->patientrequestdeposit()->create([
                    'user_id'  => Auth::user()->id,
                    'filepath' => '/upload/payment/'.$id.'/'.$filefilepath,
                ]);
            }

            return redirect()->route('patient_requests.pendingDeposit')->with('success','Approved');

        } catch (Exception $e) {
            return redirect()->route('patient_requests.depositView', $id)->with('danger','Something went wrong');
        }


    }
}
