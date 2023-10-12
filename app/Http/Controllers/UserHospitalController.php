<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hospital;
use App\Models\UserHospital;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserHospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Hospital $hospital)
    {
        $roles = Role::pluck('name','name')->all();

        return view('user_hospitals.create',compact('roles','hospital'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request, Hospital $hospital)
    // {
    //     //dd($hospital->id);
    //     $this->validate($request, [
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|same:confirm-password',
    //         'roles' => 'required',
    //         'phone' => 'required|unique:users,phone'
    //     ]);

    //     $input = $request->all();
    //     $input['password'] = Hash::make($input['password']);

    //     $user = User::create($input);
    //     $user->assignRole($request->input('roles'));

    //     UserHospital::create([
    //         'user_id' => $user->id,
    //         'hospital_id' => $hospital->id,
    //     ]);

    //     return redirect()->route('hospitals.index')
    //                     ->with('success','Hospital User created successfully');
    // }

    

    public function store(Request $request, Hospital $hospital)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'roles' => 'required',
                'phone' => 'required|unique:users,phone',
            ]);

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);

            $user = User::create($input);
            $user->assignRole($request->input('roles'));

            UserHospital::create([
                'user_id' => $user->id,
                'hospital_id' => $hospital->id,
            ]);

            // Commit the transaction if everything is successful
            DB::commit();

            return redirect()->route('hospitals.index')
                            ->with('success', 'Hospital User created successfully');
        } catch (\Exception $e) {
            // Something went wrong, so rollback the transaction
            DB::rollBack();

            // Handle the error, log it, or return a response as needed
            return back()->with('error', 'Error creating Hospital User: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(UserHospital $userHospital)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserHospital $userHospital)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserHospital $userHospital)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserHospital $userHospital)
    {
        //
    }
}
