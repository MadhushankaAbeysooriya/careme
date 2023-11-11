<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use App\DataTables\ShiftDataTable;
use App\Http\Requests\StoreShiftRequest;
use App\Http\Requests\UpdateShiftRequest;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ShiftDataTable $dataTable)
    {
        return $dataTable->render('shifts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shifts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShiftRequest $request)
    {
        Shift::create($request->all());
        return redirect()->route('shifts.index')->with('success','Shift Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $shift = Shift::find($id);

        return view('shifts.show',compact('shift'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        $shift = Shift::find($id);

        return view('shifts.edit',compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShiftRequest $request, Shift $shift)
    {
        $shift->update($request->toArray());
        return redirect()->route('shifts.index')->with('message', 'Shift Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        //
    }

    public function inactive($id){
        Shift::where('id',$id)->update(['status'=>'0']);
        return redirect()->route('shifts.index')->with( 'success','Shift De-Activated');
    }

    public function activate($id){
        Shift::where('id',$id)->update(['status'=>'1']);
        return redirect()->route('shifts.index')->with( 'success','Shift Activated');
    }
}
