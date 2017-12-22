<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
//use Illuminate\Database\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Description extends Eloquent
{
    use HybridRelations;

    protected $connection = 'mongodb';
    protected $fillable = [
        'image_id', 'description','user_id'
    ];


    public function image()
    {
        return $this->belongsTo('App\Image');
    }


}