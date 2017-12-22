<?php

namespace App;

use App\Apartment;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
//use Illuminate\Database\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Eloquent implements AuthenticatableContract,
    CanResetPasswordContract {

    use HybridRelations;
    use AuthenticableTrait;
    use  CanResetPassword;

    protected $connection = 'mongodb';
    protected $primaryKey = '_id';
    protected $hidden=['password','remember_token'];
    protected $fillable = [
        'name', 'email','password'
    ];
    public $with=['apartments'];

    public function apartments()
    {
        return $this->hasMany('App\Apartment');
    }




}