<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     return response(UserResource::collection(User::all()), 200);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->toArray();

        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];

        $validator = Validator::make($data, $rules);

        if($validator->passes())
        {
            $user = $this->createUser($data);
            return response(new UserResource($user), 201);
        }   
        else
        {
            return response(["errors" => $validator->errors()->all()], 400);
        }  
        
        return response()->json(compact('token'));
    }
    private function createUser(array $data)
    {
        $user = User::create(
        [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return new UserResource($user);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\User  $user
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(int $id)
    // {
    //     $user = User::find($id);
    //     if($user)
    //     {
    //         return response(new UserResource($user), 200);
    //     }
    //     else
    //     {
    //         return $this->userDoesntExistResponse();
    //     }
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\User  $user
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, int $id)
    // {
    //     $user = User::find($id);

    //     if($user)
    //     {
    //         $user->name = $request->input('name');
            
    //         $user->save();

    //         return response(new UserResource(User::find($id)), 200);
    //     }
    //     else
    //     {
    //         return $this->userDoesntExistResponse();
    //     }
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\User  $user
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(int $id)
    // {
    //     $user = User::find($id);

    //     if($user)
    //     {
    //         $user->delete();
    //         return response('Successfully Destroyed User', 200);
    //     }
    //     else
    //     {
    //         return $this->userDoesntExistResponse();
    //     }
    // }
}
