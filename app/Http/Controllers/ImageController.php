<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\Description;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ImageController extends Controller
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteImage(Request $request)
    {
        $image_id = $request['image_id'];
        $image = Image::find($image_id);
        unlink(public_path() . '/images/' . $image->path);


        $id=$image->apartment_id;
        $image->delete();
        Description::where('image_id', $image_id)->delete();

        //-- Refresh cache
        if (Cache::has('apartment_' . $id)) {
            Cache::forget('apartment_' . $id);
        }
        $apartment = Cache::remember('apartment_' . $id, 22 * 60, function () use ($id) {
            return Apartment::where('_id', $id)->first();
        });

        return ["status" => true];
    }
}
