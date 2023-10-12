<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Hospital;
use Illuminate\Http\Request;
use App\DataTables\HospitalDataTable;
use App\Http\Requests\StoreHospitalRequest;
use App\Http\Requests\UpdateHospitalRequest;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HospitalDataTable $dataTable)
    {
        return $dataTable->render('hospitals.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $districts = District::where('status',1)->get();
        return view('hospitals.create',compact('districts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHospitalRequest $request)
    {
        Hospital::create($request->all());
        return redirect()->route('hospitals.index')->with('success','Hospital Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hospital = Hospital::find($id);

        return view('dsdivision.show',compact('hospital'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $districts = District::where('status',1)->get();

        $hospital = Hospital::find($id);

        return view('hospitals.edit',compact('hospital','districts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHospitalRequest $request, Hospital $hospital)
    {
        $hospital->update($request->toArray());
        return redirect()->route('hospitals.index')->with('message', 'Hospital Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hospital $hospital)
    {
        //
    }

    public function inactive($id)
    {
        Hospital::where('id', $id)->update(['status' => '0']);
        return redirect()->route('hospitals.index')->with('success', 'Hospital De-Activated');
    }

    public function activate($id)
    {
        Hospital::where('id', $id)->update(['status' => '1']);
        return redirect()->route('hospitals.index')->with('success', 'Hospital Activated');
    }
}
