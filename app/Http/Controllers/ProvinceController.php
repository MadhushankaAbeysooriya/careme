<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use App\DataTables\ProvinceDataTable;
use App\Http\Requests\StoreProvinceRequest;
use App\Http\Requests\UpdateProvinceRequest;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProvinceDataTable $dataTable)
    {
        return $dataTable->render('province.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('province.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProvinceRequest $request)
    {
        Province::create($request->all());
        return redirect()->route('province.index')->with('success','Province Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $province = Province::find($id);

        return view('province.show',compact('province'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $province = Province::find($id);

        return view('province.edit',compact('province'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProvinceRequest $request, Province $province)
    {
        $province->update($request->toArray());
        return redirect()->route('province.index')->with('message', 'Province Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function inactive($id){
        Province::where('id',$id)->update(['status'=>'0']);
        return redirect()->route('province.index')->with( 'success','Province De-Activated');
    }

    public function activate($id){
        Province::where('id',$id)->update(['status'=>'1']);
        return redirect()->route('province.index')->with( 'success','Province Activated');
    }

}
