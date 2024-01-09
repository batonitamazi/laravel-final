<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'main_photo', 'description', 'user_id'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
