<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BudgetTipsController extends Controller
{
    public function index()
    {
        return view('budget-tips');
    }
}
