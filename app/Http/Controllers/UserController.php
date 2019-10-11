<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function userDoesntExist()
    {
        return response()->json(["errors" => ["User doesn't exist"]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $user = User::create(
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
        }
        catch(Exception $e)
        {
            return response()->json(["errors" => ["Something went wrong"]]);
        }

        return new UserResource(User::find($user->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = User::find($id);
        if($user !== null)
        {
            return new UserResource($user);
        }
        else
        {
            return $this->userDoesntExist();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $user = User::find($id);

        if($user)
        {
            $user->name = $request->input('name');
            
            $user->save();

            return new UserResource(User::find($id));
        }
        else
        {
            return $this->userDoesntExist();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = User::find($id);

        if($user)
        {
            $user->delete();
        }
        else
        {
            return $this->userDoesntExist();
        }
    }
}
