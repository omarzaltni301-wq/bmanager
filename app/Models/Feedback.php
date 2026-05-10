<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';
    protected $primaryKey = 'feedback_id';
    
    const CREATED_AT = 'submitted_at';
    const UPDATED_AT = 'replied_at';

    protected $fillable = ['user_id', 'first_name', 'last_name', 'email', 'category', 'message', 'status', 'admin_response'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
