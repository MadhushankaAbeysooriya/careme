<?php

namespace App\Http\Controllers;

use App\Models\BillProof;
use Illuminate\Http\Request;
use App\DataTables\BillProofDataTable;
use App\Http\Requests\StoreBillProofRequest;
use App\Http\Requests\UpdateBillProofRequest;

class BillProofController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BillProofDataTable $dataTable)
    {
        return $dataTable->render('province.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bill_proofs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBillProofRequest $request)
    {
        BillProof::create($request->all());
        return redirect()->route('bill_proofs.index')->with('success','Bill Proof Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bill_proof = BillProof::find($id);

        return view('bill_proofs.show',compact('bill_proof'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bill_proof = BillProof::find($id);

        return view('bill_proofs.edit',compact('bill_proof'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBillProofRequest $request, BillProof $billProof)
    {
        $billProof->update($request->toArray());
        return redirect()->route('bill_proofs.index')->with('message', 'Bill Proof Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillProof $billProof)
    {
        //
    }

    public function inactive($id){
        BillProof::where('id',$id)->update(['status'=>'0']);
        return redirect()->route('bill_proofs.index')->with( 'success','Bill Proof De-Activated');
    }

    public function activate($id){
        BillProof::where('id',$id)->update(['status'=>'1']);
        return redirect()->route('bill_proofs.index')->with( 'success','Bill Proof Activated');
    }
}
