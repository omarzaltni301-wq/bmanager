<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalculatorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $expenses = $user->expenses()->orderBy('entry_date', 'desc')->get();
        $incomes = $user->incomes()->orderBy('entry_date', 'desc')->get();
        $savings = $user->savings()->orderBy('entry_date', 'desc')->get();

        return view('calculator', compact('expenses', 'incomes', 'savings'));
    }

    // ── Income CRUD ──
    public function storeIncome(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'entry_date' => 'required|date',
        ]);

        $income = Auth::user()->incomes()->create($request->only('category', 'amount', 'entry_date'));

        return response()->json(['success' => true, 'income' => $income]);
    }

    public function updateIncome(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'entry_date' => 'required|date',
        ]);

        $income = Auth::user()->incomes()->findOrFail($id);
        $income->update($request->only('category', 'amount', 'entry_date'));

        return response()->json(['success' => true, 'income' => $income]);
    }

    public function deleteIncome($id)
    {
        $income = Auth::user()->incomes()->findOrFail($id);
        $income->delete();

        return response()->json(['success' => true]);
    }

    // ── Expense CRUD ──
    public function storeExpense(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'entry_date' => 'required|date',
        ]);

        $expense = Auth::user()->expenses()->create($request->only('name', 'category', 'amount', 'entry_date'));

        return response()->json(['success' => true, 'expense' => $expense]);
    }

    public function updateExpense(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'entry_date' => 'required|date',
        ]);

        $expense = Auth::user()->expenses()->findOrFail($id);
        $expense->update($request->only('name', 'category', 'amount', 'entry_date'));

        return response()->json(['success' => true, 'expense' => $expense]);
    }

    public function deleteExpense($id)
    {
        $expense = Auth::user()->expenses()->findOrFail($id);
        $expense->delete();

        return response()->json(['success' => true]);
    }

    // ── Saving CRUD ──
    public function storeSaving(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'entry_date' => 'required|date',
        ]);

        $saving = Auth::user()->savings()->create($request->only('name', 'amount', 'entry_date'));

        return response()->json(['success' => true, 'saving' => $saving]);
    }

    public function updateSaving(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'entry_date' => 'required|date',
        ]);

        $saving = Auth::user()->savings()->findOrFail($id);
        $saving->update($request->only('name', 'amount', 'entry_date'));

        return response()->json(['success' => true, 'saving' => $saving]);
    }

    public function deleteSaving($id)
    {
        $saving = Auth::user()->savings()->findOrFail($id);
        $saving->delete();

        return response()->json(['success' => true]);
    }
}
