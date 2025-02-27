<?php

// app/Models/Grade.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'desc'];
    
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
