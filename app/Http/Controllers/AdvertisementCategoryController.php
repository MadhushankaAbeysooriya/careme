<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdvertisementCategory;
use App\DataTables\AdvertisementCategoryDataTable;
use App\Http\Requests\StoreAdvertisementCategoryRequest;
use App\Http\Requests\UpdateAdvertisementCategoryRequest;

class AdvertisementCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdvertisementCategoryDataTable $dataTable)
    {
        return $dataTable->render('advertisement_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('advertisement_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertisementCategoryRequest $request)
    {
        AdvertisementCategory::create($request->all());
        return redirect()->route('advertisement_categories.index')->with('success','Advertisement Category Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $advertisementCategory = AdvertisementCategory::find($id);

        return view('advertisement_categories.show',compact('advertisementCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $advertisementCategory = AdvertisementCategory::find($id);

        return view('advertisement_categories.edit',compact('advertisementCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdvertisementCategoryRequest $request, AdvertisementCategory $advertisementCategory)
    {
        $advertisementCategory->update($request->toArray());
        return redirect()->route('advertisement_categories.index')->with('message', 'Advertisement Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdvertisementCategory $advertisementCategory)
    {
        //
    }

    public function inactive($id){
        AdvertisementCategory::where('id',$id)->update(['status'=>'0']);
        return redirect()->route('advertisement_categories.index')->with( 'success','Advertisement Category De-Activated');
    }

    public function activate($id){
        AdvertisementCategory::where('id',$id)->update(['status'=>'1']);
        return redirect()->route('advertisement_categories.index')->with( 'success','Advertisement Category Activated');
    }
}
