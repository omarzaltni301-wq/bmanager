<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'category' => 'required|string',
            'message' => 'required|string',
        ]);

        $nameParts = explode(' ', $request->name, 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

        Feedback::create([
            'user_id' => Auth::id(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'category' => $request->category,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Thank you for your feedback! We will review it and get back to you soon.');
    }
}
