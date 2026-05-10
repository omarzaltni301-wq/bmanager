<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filterDate = $request->query('date');

        $expensesQuery = $user->expenses();
        $incomesQuery = $user->incomes();
        $savingsQuery = $user->savings();

        if ($filterDate) {
            $expensesQuery = $expensesQuery->where('entry_date', $filterDate);
            $incomesQuery = $incomesQuery->where('entry_date', $filterDate);
            $savingsQuery = $savingsQuery->where('entry_date', $filterDate);
        }

        $expenses = $expensesQuery->orderBy('entry_date', 'desc')->get();
        $incomes = $incomesQuery->orderBy('entry_date', 'desc')->get();
        $savings = $savingsQuery->orderBy('entry_date', 'desc')->get();

        $totalExpenses = $expenses->sum('amount');
        $totalIncome = $incomes->sum('amount');
        $totalSavings = $savings->sum('amount');
        $remaining = $totalIncome - ($totalSavings + $totalExpenses);

        // All data (unfiltered) for charts
        $allIncomes = $user->incomes()->get();
        $allExpenses = $user->expenses()->get();

        $prices = \App\Models\Price::all()->groupBy('category');

        return view('dashboard', compact(
            'expenses', 'incomes', 'savings',
            'totalExpenses', 'totalIncome', 'totalSavings', 'remaining',
            'allIncomes', 'allExpenses', 'filterDate', 'prices'
        ));
    }
}
