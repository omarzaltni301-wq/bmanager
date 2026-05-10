<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;

    protected $primaryKey = 'saving_id';
    public $timestamps = false;

    protected $fillable = ['user_id', 'name', 'amount', 'entry_date', 'target_date', 'description'];

    protected $casts = [
        'amount' => 'decimal:3',
        'entry_date' => 'date',
        'target_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
