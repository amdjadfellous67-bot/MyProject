<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'surname', 'email', 'telephone',
        'date_of_birth', 'date_of_hire', 'department_id', 'position_id',
        'contract_type', 'experience_level', 'base_salary', 'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_hire' => 'date',
        'base_salary' => 'decimal:2',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            if (empty($employee->matricule)) {
                $employee->matricule = self::generateMatricule();
            }
        });
    }

    public static function generateMatricule()
    {
        $last = self::orderBy('id', 'desc')->first();
        $nextId = $last ? $last->id + 1 : 1;
        return 'EMP' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
}