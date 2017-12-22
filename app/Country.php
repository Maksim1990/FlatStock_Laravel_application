<?php

namespace App;

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
//use Illuminate\Database\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;


class Country extends Eloquent {

    use HybridRelations;

    protected $connection = 'mongodb';
    protected $fillable = [
        'name', 'code'
    ];







}