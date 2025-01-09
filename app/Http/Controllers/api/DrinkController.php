<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drink;
use App\Http\Resources\Drink as DrinkResource;
use App\Http\Controllers\api\ResponseController;
use App\Http\Requests\DrinkRequest;
use App\Http\Controllers\api\TypeController;

class DrinkController extends ResponseController {

    public function getDrinks() {

        $drinks =Drink::with( "type", "package" )->get();

        return $this->sendResponse( DrinkResource::collection( $drinks ), "Összes ital betöltve!" );
    }

    public function getDrink( Request $request ) {

        $drink = Drink::where( "drink", $request[ "drink" ] )->first();

        if( is_null( $drink ) ) {

            return $this->sendError( "Adathiba!", [ "Nincs ilyen ital!" ] );

        }else{

            return $this->sendResponse( new DrinkResource( $drink ), "Ital betöltve!" );

        }

    }

    public function newDrink( DrinkRequest $request ) {

        $request->validated();

        $drink = new Drink();

        $typeRequest = new Request( [ "type" => $request[ "type" ] ] );
        $packageRequest = new Request( [ "package" => $request[ "package" ] ] );
        
        $drink->drink = $request[ "drink" ];
        $drink->amount = $request[ "amount" ];
        $drink->type_id = ( new TypeController )->getTypeId( $typeRequest );
        $drink->package_id = ( new PackageController )->getPackageId( $packageRequest );

        $drink->save();

        return $this->sendResponse( $drink, "Új ital hozzáadva!" );
    }

    public function updateDrink( DrinkRequest $request ) {

        $drink = Drink::where( "drink", $request[ "drink" ] )->first();

        if( is_null( $drink )) {

            return $this->sendError( "Hiba!", [ "Nincs ilyen ital!" ] );

        }else{

            $typeRequest = new Request( [ "type" => $request[ "type" ] ] );
            $packageRequest = new Request( [ "package" => $request[ "package" ] ] );

            $drink->drink = $request[ "drink" ];
            $drink->amount = $request[ "amount" ];
            $drink->type_id = ( new TypeController )->getTypeId( $typeRequest );
            $drink->package_id = ( new PackageController )->getPackageId( $packageRequest );

            $drink->update();

            return $this->sendResponse( $drink, "Ital módosítása sikeres!" );
        }

    }

    public function destroyDrink( Request $request ) {

        $drink = Drink::where( "drink", $request[ "drink" ] )->first();

        if( is_null( $drink) ) {

            return $this->sendError( "Hiba!", [ "Nincs ilyen ital!" ] );

        }else{

            $drink->delete();

        }

        return $this->sendResponse( $drink, "Ital törlése sikeres!" );

    }
    
}
