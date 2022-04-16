<?php

namespace App\Http\Controllers\Api\User;


use App\Models\User;
use Illuminate\Http\Request;
use App\Events\User\userCreated;
use App\Events\User\userUpdated;
use App\Events\User\userDestroyed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ValidateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(env('API_PAGINATION', 10));
        return response()->json([
            'success'=> true,
            'message' => 'A list of users',
            'data'=>$users], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\User\ValidateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateUserRequest $request)
    {
        $data = $request->validated();

        $data['password']  = Hash::make($data['password']);        

        $new_user= User::create($data);       
        $credentials= [ 'email' => $request->email,  'password' => $request->password ];

        $user =  Auth::attempt($credentials); // login user
        $token = auth()->user()->createToken('token')->accessToken; 

        event(new userCreated($new_user));

        return response()->json([
            'success'=> true,
            'message'=> 'User created successfuly',
            'data' => $user,
            'token' => $token 
            ],  201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user= User::findOrFail($id);
        return response()->json([
            'success'=> true,
            'message'=> 'Á single user retrieved successfully', 
            'data'=>$user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\User\UpdateUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->validated(); 

        $user = User::findOrFail($id);
        $user->update($data);
        
        event(new UserUpdated($user));
        return response()->json([
            'success'=> true, 
            'message'=>'User updated successfuly', 
            'data'=>$user],  200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user= User::findOrFail($id)->delete();
        event(new UserDestroyed($user));
        return response()->json([
            'success'=> true, 
            'message'=> 'User deleted successfuly', 
            'data'=>true], 200);
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore( $id)
    {
        $user = User::onlyTrashed()->findOrFail($id)->restore(); 
        return response()->json([
            'success'=> true, 
            'message'=>'User restored', 
            'data'=>$user],  200);
    }

    /**
     * Parmanently remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function parmanentlyDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id)->forceDelete();
        event(new userDestroyed($user)); 
        return response()->json([
            'success' => true,
            'message' => 'User parmanently deleted!',
            'data' => $user
        ], 200);
    }
}
