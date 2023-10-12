<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\DataTables\DistrictDataTable;
use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DistrictDataTable $dataTable)
    {
        return $dataTable->render('district.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $province = Province::where('status', 1)->get();
        return view('district.create', compact('province'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDistrictRequest $request)
    {
        District::create($request->all());
        return redirect()->route('district.index')->with('success', 'District Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $district = District::find($id);

        return view('district.show', compact('district'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $province = Province::where('status', 1)->get();
        $district = District::find($id);

        return view('district.edit', compact('province', 'district'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDistrictRequest $request, District $district)
    {
        $district->update($request->toArray());
        return redirect()->route('district.index')->with('message', 'District Updated');
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
        District::where('id', $id)->update(['status' => '0']);
        return redirect()->route('district.index')->with('success', 'District De-Activated');
    }

    public function activate($id)
    {
        District::where('id', $id)->update(['status' => '1']);
        return redirect()->route('district.index')->with('success', 'District Activated');
    }
}
