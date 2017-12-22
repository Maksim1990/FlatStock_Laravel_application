<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
//use Illuminate\Database\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Image extends Eloquent
{
    use HybridRelations;

    protected $connection = 'mongodb';
    protected $fillable = [
        'user_id', 'path','apartment_id'
    ];


    public $with=['descriptions'];

    public function descriptions()
    {
        return $this->hasMany('App\Description');
    }
    public function apartment()
    {
        return $this->belongsTo('App\Apartment');
    }


}