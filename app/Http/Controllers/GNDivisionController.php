<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\GNDivision;
use Illuminate\Http\Request;
use App\DataTables\GNDivisionDataTable;
use App\Http\Requests\StoreGNDivisionRequest;
use App\Http\Requests\UpdateGNDivisionRequest;

class GNDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GNDivisionDataTable $dataTable)
    {
        return $dataTable->render('gndivisions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $district = District::where('status',1)->get();
        return view('gndivisions.create',compact('district'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGNDivisionRequest $request)
    {
        GNDivision::create($request->all());
        return redirect()->route('gndivisions.index')->with('success','GN Division Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gndivision = GNDivision::find($id);

        return view('gndivisions.show',compact('gndivision'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $district = District::where('status',1)->get();

        $gndivision = GNDivision::find($id);

        return view('gndivisions.edit',compact('gndivision','district'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGNDivisionRequest $request, GNDivision $gndivision)
    {
        $gndivision->update($request->toArray());
        return redirect()->route('gndivisions.index')->with('message', 'GN Division Updated');
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
        GNDivision::where('id', $id)->update(['status' => '0']);
        return redirect()->route('gndivisions.index')->with('success', 'GN Division De-Activated');
    }

    public function activate($id)
    {
        GNDivision::where('id', $id)->update(['status' => '1']);
        return redirect()->route('gndivisions.index')->with('success', 'GN Division Activated');
    }
}
