<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $primaryKey = 'expense_id';
    public $timestamps = false;

    protected $fillable = ['user_id', 'name', 'category', 'amount', 'entry_date', 'description'];

    protected $casts = [
        'amount' => 'decimal:3',
        'entry_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
