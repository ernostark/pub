<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Type as TypeResource;
use App\Models\Type;
use App\Http\Requests\TypeRequest;
use App\Http\Controllers\api\ResponseController;

class TypeController extends ResponseController {

    public function getTypes() {

        $types = Type::all();

        return $this->sendResponse( TypeResource::collection( $types ), "Összes típus betöltve!");
        
    }

    public function getType( Request $request ) {

        $type = Type::where( "type", $request[ "type" ] )->first();

        if( is_null( $type )) {

            return $this->sendError( "Hiba!", [ "A típus nem létezik!" ], 406 );

        }else{

            return $this->sendResponse( new TypeResource( $type ), "A típus betöltve!" );

        }

    }

    public function newType( TypeRequest $request ) {

        $request->validated();

        $type = new Type();

        $type->type = $request[ "type" ];

        $type->save();

        return $this->sendResponse( new TypeResource( $type ), "Új típus felvéve!" );

    }

    public function updateType( TypeRequest $request ) {

        $request->validated();

        $type = Type::find( $request [ "id" ] );

        if( !is_null( $type ) ) {

            $type->type = $request[ "type" ];

            $type->update();

            return $this->sendResponse( new TypeResource( $type ), "Típus módosítva!");

        }else{

            return $this->sendError( "Hiba!", [ "Típus nem létezik!" ], 406 );

        }

    }

    public function destroyType( Request $request ) {

        $type = Type::where( "type", $request[ "type" ])->first();

        if( !is_null( $type ) ) {

            $type->delete();

            return $this->sendResponse( $type, "Típus törölve!" );

        }else{

            return $this->sendError( "Hiba!", [ "Típus nem létezik!" ], 406 );
        }

    }

    public function getTypeId( Request $typeName ) {

        $type = Type::where( "type", $typeName[ "type" ] )->first();

        $id = $type->id;

        return $id;
    }

}
