<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quiz_categories extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        
    ];
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
