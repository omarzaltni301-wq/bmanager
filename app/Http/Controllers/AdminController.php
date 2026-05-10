<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Feedback;
use App\Models\Price;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $usersCount = User::count();
        $feedbacksCount = Feedback::count();
        $pricesCount = Price::count();
        
        return view('admin.dashboard', compact('usersCount', 'feedbacksCount', 'pricesCount'));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function feedbacks()
    {
        $feedbacks = Feedback::orderBy('submitted_at', 'desc')->get();
        return view('admin.feedbacks', compact('feedbacks'));
    }

    public function prices()
    {
        $prices = Price::orderBy('category')->get();
        return view('admin.prices', compact('prices'));
    }

    public function storePrice(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'item_name' => 'required|string',
            'price' => 'required|numeric',
            'source' => 'required|string',
        ]);

        Price::create([
            'category' => $request->category,
            'item_name' => $request->item_name,
            'price' => $request->price,
            'source' => $request->source,
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Price added successfully.');
    }

    public function updatePrice(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string',
            'item_name' => 'required|string',
            'price' => 'required|numeric',
            'source' => 'required|string',
        ]);

        $price = Price::findOrFail($id);
        $price->update([
            'category' => $request->category,
            'item_name' => $request->item_name,
            'price' => $request->price,
            'source' => $request->source,
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Price updated successfully.');
    }

    public function deletePrice($id)
    {
        Price::findOrFail($id)->delete();
        return back()->with('success', 'Price deleted successfully.');
    }
}
