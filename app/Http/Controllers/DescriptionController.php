<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\Description;
use App\Image;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Cache;

class DescriptionController extends Controller
{
    public function addDescription(Request $request)
    {
        $description = $request['image_description'];
        $image_id = $request['image_id'];

        $image=Image::where('_id', $image_id)->first();
        $descriptionItem = Description::where('image_id', $image_id)->first();
        if ($descriptionItem) {
            $descriptionItem->description = $description;
            $descriptionItem->save();
        } else {
            $descriptionItem= Description::create([
                'user_id' => Auth::id(),
                'image_id' => $image_id,
                'description' => $description
            ]);
        }


        $id=$image->apartment_id;

        //-- Refresh cache
        if (Cache::has('apartment_' . $id)) {
            Cache::forget('apartment_' . $id);
        }
        $apartment = Cache::remember('apartment_' . $id, 22 * 60, function () use ($id) {
            return Apartment::where('_id', $id)->first();
        });

        return ["status" => true];
    }

    public function deleteDescription(Request $request)
    {
        $image_id = $request['image_id'];

        $image=Image::where('_id', $image_id)->first();

        $descriptionItem = Description::where('image_id', $image_id)->delete();

        //-- Refresh cache
        $id=$image->apartment_id;
        if (Cache::has('apartment_' . $id)) {
            Cache::forget('apartment_' . $id);
        }
        $apartment = Cache::remember('apartment_' . $id, 22 * 60, function () use ($id) {
            return Apartment::where('_id', $id)->first();
        });

        return ["status" => true];
    }



}
