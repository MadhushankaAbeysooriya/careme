<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\AdvertisementCategory;
use App\DataTables\AdvertisementDataTable;
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
        $advertisementCategories = AdvertisementCategory::where('status',1)->get();
        return view('advertisements.create',compact('advertisementCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertisementRequest $request)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            // Attempt to create a new Person record
            $advertisement = Advertisement::create($request->all());

            if ($request->hasFile('filepath')) {
                // Define the destination path for personal photos
                $destinationPersonal = public_path('/upload/advertisements/'.$advertisement->id.'/');

                // Ensure the destination directory exists, create it if not
                if (!File::isDirectory($destinationPersonal)) {
                    File::makeDirectory($destinationPersonal, 0777, true, true);
                }

                // Generate a unique filename for the uploaded filepath
                $extPersonal = $request->file('filepath')->extension();
                $filePersonal = $advertisement->id.'.'.$extPersonal;

                // Move the uploaded file to the destination
                $request->file('filepath')->move($destinationPersonal, $filePersonal);

                // Update the person record with the filepath
                $advertisement->update([
                    'filepath' => '/upload/advertisements/'.$advertisement->id.'/'.$filePersonal,
                    'user_id' => Auth::user()->id, // Use auth() helper
                    //'person_status_id' => $person_status->id,
                ]);
            }

            // Commit the database transaction
            DB::commit();

            return redirect()->route('advertisements.index')->with('success', 'Advertisement Created');
        } catch (Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            // Handle any exceptions that occur during the process
            return redirect()->route('advertisements.create')->with('danger', 'An error occurred while creating the advertisement.');
        }
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

    public function inactive($id)
    {
        Advertisement::where('id', $id)->update(['status' => '0']);
        return redirect()->route('advertisements.index')->with('success', 'Advertisement De-Activated');
    }

    public function activate($id)
    {
        Advertisement::where('id', $id)->update(['status' => '1']);
        return redirect()->route('advertisements.index')->with('success', 'Advertisement Activated');
    }

    public function delete($id)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the Advertisement record by ID
            $advertisement = Advertisement::findOrFail($id);

            // Get the path to the directory to be deleted
            $directoryPath = public_path('/upload/advertisements/'.$advertisement->id);

            // // Delete the associated image file
            // $filePath = public_path($advertisement->filepath);
            // if (File::exists($filePath)) {
            //     File::delete($filePath);
            // }

            // Check if the directory exists and then delete it
            if (File::isDirectory($directoryPath)) {
                File::deleteDirectory($directoryPath);
            }

            // Delete the Advertisement record from the database
            $advertisement->delete();


            // Commit the database transaction
            DB::commit();

            return redirect()->route('advertisements.index')->with('success', 'Advertisement and associated image deleted successfully');
        } catch (Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            // Handle any exceptions that occur during the process
            return redirect()->route('advertisements.index')->with('error', 'An error occurred while deleting the Advertisement and its image.');
        }

    }
}
