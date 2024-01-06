<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use App\DataTables\LanguageDataTable;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LanguageDataTable $dataTable)
    {
        return $dataTable->render('languages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('languages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLanguageRequest $request)
    {
        Language::create($request->all());
        return redirect()->route('languages.index')->with('success','Language Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $language = Language::find($id);

        return view('languages.show',compact('language'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $language = Language::find($id);

        return view('languages.edit',compact('language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLanguageRequest $request, Language $language)
    {
        $language->update($request->toArray());
        return redirect()->route('languages.index')->with('message', 'Language Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        //
    }

    public function inactive($id){
        Language::where('id',$id)->update(['status'=>'0']);
        return redirect()->route('languages.index')->with( 'success','Language De-Activated');
    }

    public function activate($id){
        Language::where('id',$id)->update(['status'=>'1']);
        return redirect()->route('languages.index')->with( 'success','Language Activated');
    }
}
