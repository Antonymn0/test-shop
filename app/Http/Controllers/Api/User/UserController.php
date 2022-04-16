<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validated();

        $data['password']  = Hash::make($data['password']);        

        $new_user= User::create($data);       
        $credentials= [ 'email' => $new_user->email,  'password' => $data['password'] ];

        $user =  Auth::attempt($credentials); // login user
        $token = auth()->user()->createToken('token')->accessToken;        

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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validated(); 

        $user->update($data);

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
