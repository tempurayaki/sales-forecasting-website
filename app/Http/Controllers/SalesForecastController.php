<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesForecastController extends Controller
{
    public function index()
    {
        return view('forecast.index');
    }
}
