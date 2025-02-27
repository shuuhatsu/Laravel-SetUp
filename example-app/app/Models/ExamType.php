<?php

// app/Models/ExamType.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'desc'];
    
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}