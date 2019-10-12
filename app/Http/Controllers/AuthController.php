<?php

namespace App\Http\Controllers;

use App\Auth;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions;
use App\Http\Resources\User as UserResource;

class AuthController extends Controller
{    
    public function Login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try 
        {
            if (! $token = JWTAuth::attempt($credentials))
            {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } 
        catch (JWTException $e)
        {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function GetCurrentUser(Request $request)
    {
        try 
        {
            if (! $user = JWTAuth::parseToken()->authenticate()) 
            {
                return response()->json(['user_not_found'], 404);
            }
        } 
        catch(TokenExpiredException $e)
        {
            return response()->json(['token_expired'], $e->getStatusCode());
        } 
        catch(TokenInvalidException $e)
        {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } 
        catch (JWTException $e)
        {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    
        // the token is valid and we have found the user via the sub claim
        return response(new UserResource($user), 200);
    }
}
