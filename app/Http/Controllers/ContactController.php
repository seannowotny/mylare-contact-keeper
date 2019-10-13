<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Contact as ContactResource;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $contacts = $user->contacts;

        return ContactResource::collection($contacts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $data = $request->toArray();

        $rules = [
            'type' => 'required|in:personal,professional',
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'phone' => 'required',
        ];

        $validator = Validator::make($data, $rules);

        if($validator->passes())
        {
            $contact = $user->contacts()->create([
                'type' => $data['type'],
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);
    
            return new ContactResource($contact);
        }
        else
        {
            return response(["errors" => $validator->errors()->all()], 400);
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
