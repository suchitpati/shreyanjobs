<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return response()->json($countries);
    }

    public function states($countryName)
    {    
        $country = Country::where('name', $countryName)->first();

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        $states = $country->states;
        return response()->json($states);
    }
}
