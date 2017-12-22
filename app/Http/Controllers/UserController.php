<?php

namespace App\Http\Controllers;

use App\Country;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mongo()
    {
//-- Create new dbs
//        Schema::create('countries', function($collection)
//        {
//            $collection->index('name');
//
//            $collection->unique('code');
//        });



        //$user = DB::collection('users')->get();
//        User::create([
//            'username' => 'Denis',
//            'email' => 'denis@gmail.com'
//            ]);

        //-- Insert data to Country document
//        Country::create([
//            'name' => 'Belarus',
//            'code' => 'BY'
//        ]);
       // DB::collection('users')->where('username', 'Andrey')->push('messages', array('from' => 'Jane Doe', 'message' => 'Hi John'));
      $user = DB::collection('users')->where('name', 'Maksim')->first();
//        DB::collection('users')->where('username', 'Andrey')->pull('messages', array('from' => 'Jane Doe', 'message' => 'Hi John'));
//        DB::collection('users')->where('username', 'Andrey')->unset('messages');


       // $user = DB::collection('users')->where('username', 'Denis')->delete();
      var_dump($user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }





}
