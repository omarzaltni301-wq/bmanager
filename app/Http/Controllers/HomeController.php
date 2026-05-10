<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $prices = Price::all()->groupBy('category');
        return view('home', compact('prices'));
    }
}
