<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DrinkController;
use App\Http\Controllers\api\TypeController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post( "/register", [ AuthController::class, "register" ] );
Route::post( "/login", [ AuthController::class, "login" ] );
Route::get( "/users", [ AuthController::class, "getUsers" ]);

Route::get( "/drinks", [ DrinkController::class, "getDrinks" ]);
Route::get( "/drink", [ DrinkController::class, "getDrink" ]);
Route::post( "/newdrink", [ DrinkController::class, "newDrink" ]);
Route::put( "/updatedrink", [ DrinkController::class, "updateDrink" ]);
Route::delete( "/deletedrink", [ DrinkController::class, "destroyDrink" ]);

Route::get( "/types", [ TypeController::class, "getTypes" ]);
Route::get( "/type", [ TypeController::class, "getType" ]);
Route::post( "/newtype", [ TypeController::class, "newType" ]);
Route::put( "/updatetype", [ TypeController::class, "updateType" ]);
Route::delete( "/deletetype", [ TypeController::class, "destroyType" ]);
Route::get( "/gettypeid", [ TypeController::class, "getTypeId" ]);

Route::get( "/packages", [ PackageController::class, "getPackages" ]);
Route::get( "/package", [ PackageController::class, "getPackage" ]);
Route::post( "/newpackage", [ PackageController::class, "newPackage" ]);
Route::put( "/updatepackage", [ PackageController::class, "updatePackage" ]);
Route::delete( "/deletepackage", [ PackageController::class, "destroyPackage" ]);
Route::get( "/getpackageid", [ PackageController::class, "getPackageId" ]);
