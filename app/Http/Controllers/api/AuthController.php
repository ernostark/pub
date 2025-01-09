<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\ResponseController;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Http\Requests\LoginRequest;

class AuthController extends ResponseController
{
    public function register( RegisterRequest $request ){
        
        $request->validated();

        $user = User::create([
            "name" => $request["name"],
            "email" => $request["email"],
            "password" => bcrypt( $request["password"])
        ]);

        return $this->sendResponse( $user, "Sikeres regisztráció" );
        
    }

    public function login( LoginRequest $request ){
        $request->validated();

        if ( Auth::attempt([ "name" => $request["name"], "password" => $request["password"]])) {
            return Auth::user();
        }else{
            return "He he he...";
        }

    }

    public function logout(){

    }

    public function getUsers(){
        $users = User::all();
        return $users;
    }
}
