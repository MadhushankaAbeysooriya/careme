<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\DataTables\UserPatientDataTable;
use App\DataTables\UserCareTakerDataTable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

    public function indexPatient(UserPatientDataTable $dataTable)
    {
        return $dataTable->render('users.index_patient');
    }

    public function indexCareTaker(UserCareTakerDataTable $dataTable)
    {
        return $dataTable->render('users.index_care_taker');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();

        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'phone' => 'required|unique:users,phone',
            'dob' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);

        $user = User::find($id);

        $dob = Carbon::parse($user->dob);
        $age = $dob->age;

        return view('users.show',compact('user','age'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);

        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->toArray();

        return view('users.edit',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'phone' => 'required|unique:users,phone,'.$id,
            'dob' => 'required',
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    public function inactive($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        User::where('id',$id)->update(['status'=>'0']);
         return redirect()->route('users.index')->with( 'success',' account suspended');
    }

    public function activate($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        User::where('id',$id)->update(['status'=>'1']);
        return redirect()->route('users.index')->with( 'success',' account activated');
    }

    public function resetpass($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        User::where('id',$id)->update(['password' => Hash::make('abc@123')]);
        return redirect()->route('users.index')->with( 'success', ' Password Reset as abc@123');
    }

    public function validated($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        User::where('id',$id)->update(['validated'=>'1']);
         return redirect()->back()->with( 'success',' Account Validated');
    }

    public function notvalidated($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        User::where('id',$id)->update(['validated'=>'0']);
        return redirect()->back()->with( 'success',' Account Not-Validated');
    }
}
