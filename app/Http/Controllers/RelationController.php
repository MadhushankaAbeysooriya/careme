<?php

namespace App\Http\Controllers;

use App\Models\Relation;
use Illuminate\Http\Request;
use App\DataTables\RelationDataTable;
use App\Http\Requests\StoreRelationRequest;
use App\Http\Requests\UpdateRelationRequest;

class RelationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RelationDataTable $dataTable)
    {
        return $dataTable->render('relations.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('relations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRelationRequest $request)
    {
        Relation::create($request->all());
        return redirect()->route('relations.index')->with('success','Relation Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $relation = Relation::find($id);

        return view('relations.show',compact('relation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $relation = Relation::find($id);

        return view('relations.edit',compact('relation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRelationRequest $request, Relation $relation)
    {
        $relation->update($request->toArray());
        return redirect()->route('relations.index')->with('message', 'Relation Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Relation $relation)
    {
        //
    }

    public function inactive($id){
        Relation::where('id',$id)->update(['status'=>'0']);
        return redirect()->route('relations.index')->with( 'success','Relation De-Activated');
    }

    public function activate($id){
        Relation::where('id',$id)->update(['status'=>'1']);
        return redirect()->route('relations.index')->with( 'success','Relation Activated');
    }
}
