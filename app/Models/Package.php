<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model {

    public $timestamps = false;

    public function drink() {

        return $this->hasMany( Drink::class );
    }
}
