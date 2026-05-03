<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'level', 'base_salary', 'description'];

    protected $casts = [
        'base_salary' => 'decimal:2',
    ];

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}