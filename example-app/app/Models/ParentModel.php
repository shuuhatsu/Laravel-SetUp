<?php

// app/Models/Parent.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'password', 'fname', 'lname', 'dob', 'phone', 'mobile', 'status', 'last_login_date', 'last_login_ip'];
    
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}