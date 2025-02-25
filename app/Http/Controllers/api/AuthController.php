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

        if ( Auth::attempt([ "name" => $request["name"], "password" => $request["password"] ]) ){

            $user = Auth::user();
            ( new BannerController )->resetLoginCounter( $user->name );
            $token = $user->createToken( $user->name . "Token" )->plainTextToken;
            $data = [
                "name" => $user->name,
                "token" => $token
            ]; 
            
            return $this->sendResponse( $data, "Sikeres bejelentkezés!" );

        }else{

            ( new BannerController )->setLoginCounter( $request["name"] );

            $counter = ( new BannerController )->getLoginCounter( $request["name"] );

            if ( $counter > 3 ) {

                $time = Carbon::now();

                return $time;
            }

            return $counter;

            //return $this->sendError( "Azonosítási hiba!", "Hibás felhasználónév vagy jelszó!", 405 );

        }

    }

    public function logout(){

        $user = auth("sanctum")->user();
        
        $user->currentAccessToken()->delete();

        return $this->sendResponse( $user->name, "Sikeres kijelentkezés!" );

    }

    public function getUsers(){

        $users = User::all();
        return $users;

    }
}
