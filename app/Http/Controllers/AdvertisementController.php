<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Http\Requests\StoreAdvertisementRequest;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdvertisementDataTable $dataTable)
    {
        return $dataTable->render('advertisements.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('advertisements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertisementRequest $request)
    {
        Advertisement::create($request->all());
        return redirect()->route('advertisements.index')->with('success', 'Advertisement Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advertisement $advertisement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        //
    }
}
