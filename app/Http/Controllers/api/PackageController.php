<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Http\Requests\PackageRequest;
use App\Http\Controllers\api\ResponseController;
use App\Http\Resources\Package as PackageResource;

class PackageController extends ResponseController {
    
    public function getPackages() {

        $packages = Package::all();

        return $this->sendResponse( PackageResource::collection( $packages ), "Kiszerelések betöltve");
        
    }

    public function getPackage( Request $request ) {

        $package = Package::where( "package", $request[ "package" ] )->first();
        if( is_null( $package )) {

            return $this->sendError( "Hiba!", [ "Nincs ilyen kiszerelés!" ], 406 );
        }

        return $this->sendResponse( new PackageResource( $package ), "Kiszerelés betöltve!" );

    }

    public function newPackage( PackageRequest $request ) {

        $request->validated();

        $package = new Package();

        $package->package = $request[ "package" ];

        $package->save();

        return $this->sendResponse( new PackageResource( $package ), "Új kiszerelés felvéve!");

    }

    public function updatePackage( PackageRequest $request ) {

        $request->validated();

        $package = Package::find( $request [ "id" ] );

        if( !is_null( $package ) ) {

            $package->package = $request[ "package" ];

            $package->update();

            return $this->sendResponse( new PackageResource( $package ), "Kiszerelés módosítva!"); 

        }else{

            return $this->sendError( "Hiba!", [ "Nincs ilyen kiszerelés!" ], 406 );

        }

    }

    public function destroyPackage( Request $request ) {

        $package = Package::where( "package", $request[ "package" ] )->first();

        if( !is_null( $package ) ) {

            $package->delete();

            return $this->sendResponse( new PackageResource( $package ), "Kiszerelés törölve!" );

        }else{

            return $this->sendError( "Adathiba", [ "Nincs ilyen kiszerelés!" ], 406 );

        }

    }

    public function getPackageId( Request $packageName ) {

        $package = Package::where( "package", $packageName[ "package" ] )->first();

        $id = $package->id;

        return $id;

    }

}
