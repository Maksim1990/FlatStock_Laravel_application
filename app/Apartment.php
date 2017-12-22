<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
//use Illuminate\Database\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Apartment extends Eloquent
{
    use HybridRelations;

    protected $connection = 'mongodb';
    protected $fillable = [
        'user_id', 'street', 'city', 'lat', 'lng', 'house', 'room', 'description', 'country','phone','email','flatsNo','price'
    ];

    public $with=['images'];

    public function images()
    {
        return $this->hasMany('App\Image');
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }


}
