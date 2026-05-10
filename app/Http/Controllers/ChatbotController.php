<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Saving;
use Carbon\Carbon;

class ChatbotController extends Controller
{
    public function message(Request $request)
    {
        $message = strtolower($request->input('message', ''));
        $user = Auth::user();

        // 1. Help with saving tips
        if (str_contains($message, 'save') || str_contains($message, 'tip')) {
            $tips = [
                "Track every penny: Use the calculator to record all expenses.",
                "The 50/30/20 rule: 50% for needs, 30% for wants, and 20% for savings.",
                "Avoid impulse buying: Wait 24 hours before making a big purchase.",
                "Cook at home: Preparing your own meals in Tunisia is much cheaper than eating out.",
                "Check prices: Use our 'Price Awareness' section to find the best market values."
            ];
            return response()->json(['reply' => "💡 Saving Tip: " . $tips[array_rand($tips)]]);
        }

        // 2. Add income of today
        // Format: "add income [amount] [category]"
        if (str_contains($message, 'add income')) {
            preg_match('/add income (\d+(?:\.\d+)?) ?(\w+)?/', $message, $matches);
            if (count($matches) >= 2) {
                $amount = $matches[1];
                $category = $matches[2] ?? 'Others';
                
                $income = $user->incomes()->create([
                    'category' => ucfirst($category),
                    'amount' => $amount,
                    'entry_date' => Carbon::today()
                ]);

                return response()->json(['reply' => "✅ Success! I added " . number_format($amount, 2) . " TND to your '" . ucfirst($category) . "' income for today."]);
            }
            return response()->json(['reply' => "To add income, please say: 'add income [amount] [category]'. Example: 'add income 1000 salary'"]);
        }

        // 3. Add expense of today
        // Format: "add expense [amount] [category] [name]"
        if (str_contains($message, 'add expense')) {
            // Pattern to catch: amount, category (optional), name (optional/rest of string)
            preg_match('/add expense (\d+(?:\.\d+)?) ?(\w+)? ?(.*)?/', $message, $matches);
            if (count($matches) >= 2) {
                $amount = $matches[1];
                $category = !empty($matches[2]) ? ucfirst($matches[2]) : 'Other';
                $name = !empty($matches[3]) ? $matches[3] : 'New Expense';
                
                $expense = $user->expenses()->create([
                    'name' => ucfirst($name),
                    'category' => $category,
                    'amount' => $amount,
                    'entry_date' => Carbon::today()
                ]);

                return response()->json(['reply' => "💸 Expense added: " . number_format($amount, 2) . " TND for '" . ucfirst($name) . "' (" . $category . ")."]);
            }
            return response()->json(['reply' => "To add an expense, say: 'add expense [amount] [category] [name]'. Example: 'add expense 50 food groceries'"]);
        }

        // 4. Add saving of today
        // Format: "add saving [amount] [name]"
        if (str_contains($message, 'add saving')) {
            preg_match('/add saving (\d+(?:\.\d+)?) ?(.*)?/', $message, $matches);
            if (count($matches) >= 2) {
                $amount = $matches[1];
                $name = !empty($matches[2]) ? $matches[2] : 'New Saving';
                
                $saving = $user->savings()->create([
                    'name' => ucfirst($name),
                    'amount' => $amount,
                    'entry_date' => Carbon::today()
                ]);

                return response()->json(['reply' => "🏦 Saving added: " . number_format($amount, 2) . " TND to '" . ucfirst($name) . "'."]);
            }
            return response()->json(['reply' => "To add a saving, say: 'add saving [amount] [name]'. Example: 'add saving 100 emergency fund'"]);
        }

        // 5. Delete entries of today
        if (str_contains($message, 'delete')) {
            if (str_contains($message, 'income')) {
                $item = $user->incomes()->whereDate('entry_date', Carbon::today())->latest()->first();
                $type = 'income';
            } elseif (str_contains($message, 'expense')) {
                $item = $user->expenses()->whereDate('entry_date', Carbon::today())->latest()->first();
                $type = 'expense';
            } elseif (str_contains($message, 'saving')) {
                $item = $user->savings()->whereDate('entry_date', Carbon::today())->latest()->first();
                $type = 'saving';
            }

            if (isset($item) && $item) {
                $item->delete();
                return response()->json(['reply' => "🗑️ I have deleted your last $type entry from today."]);
            }
            return response()->json(['reply' => "I couldn't find any entries to delete for today."]);
        }

        // Default response
        return response()->json(['reply' => "🤖 I can help you with:\n- Saving tips ('give me a tip')\n- Add Income ('add income 500 salary')\n- Add Expense ('add expense 50 food groceries')\n- Add Saving ('add saving 100 emergency')\n- Delete ('delete income/expense/saving')"]);
    }
}

