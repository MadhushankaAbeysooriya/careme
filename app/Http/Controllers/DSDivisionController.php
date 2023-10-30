<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDSDivisionRequest;
use App\Models\DSDivision;
use Illuminate\Http\Request;
use App\DataTables\DSDivisionDataTable;
use App\Http\Requests\StoreDSDivisionRequest;
use App\Models\District;

class DSDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DSDivisionDataTable $dataTable)
    {
        return $dataTable->render('dsdivisions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $district = District::where('status',1)->get();
        return view('dsdivisions.create',compact('district'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDSDivisionRequest $request)
    {
        DSDivision::create($request->all());
        return redirect()->route('dsdivisions.index')->with('success','DS Division Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dsdivision = DSDivision::find($id);

        return view('dsdivisions.show',compact('dsdivision'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $district = District::where('status',1)->get();

        $dsdivision = DSDivision::find($id);

        return view('dsdivisions.edit',compact('dsdivision','district'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDSDivisionRequest $request, DSDivision $dsdivision)
    {
        $dsdivision->update($request->toArray());
        return redirect()->route('dsdivisions.index')->with('message', 'DS Division Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function inactive($id)
    {
        DSDivision::where('id', $id)->update(['status' => '0']);
        return redirect()->route('dsdivisions.index')->with('success', 'District De-Activated');
    }

    public function activate($id)
    {
        DSDivision::where('id', $id)->update(['status' => '1']);
        return redirect()->route('dsdivisions.index')->with('success', 'District Activated');
    }
}
