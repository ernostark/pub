<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class BannerController extends Controller
{

    public function getLoginCounter( $name ) {

        $user = User::where( "name", $name )->first();
        $counter = $user->login_counter;

        return $counter;

    }

    public function setLoginCounter( $name ) {

        $user = User::where( "name", $name )->first();
        $user->increment( "login_counter" );

    }

    public function resetLoginCounter( $name ) {

        $user = User::where( "name", $name )->first();
        $user->login_counter = 0;

        $user->update();

    }

    public function getBanningTime() {

    }

    public function setBanningTime() {

    }

    public function resetBanningTime() {

    }
    
}
