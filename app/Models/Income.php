<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $primaryKey = 'income_id';
    public $timestamps = false;

    protected $fillable = ['user_id', 'category', 'amount', 'entry_date', 'description'];

    protected $casts = [
        'amount' => 'decimal:3',
        'entry_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
