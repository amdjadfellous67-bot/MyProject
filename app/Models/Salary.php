<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'gross_salary', 'bonus_seniority', 'bonus_performance',
        'bonus_attendance', 'deduction_cnss', 'deduction_advances',
        'deduction_absences', 'net_salary', 'month', 'year'
    ];

    protected $casts = [
        'gross_salary' => 'decimal:2',
        'bonus_seniority' => 'decimal:2',
        'bonus_performance' => 'decimal:2',
        'bonus_attendance' => 'decimal:2',
        'deduction_cnss' => 'decimal:2',
        'deduction_advances' => 'decimal:2',
        'deduction_absences' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getTotalBonusesAttribute()
    {
        return $this->bonus_seniority + $this->bonus_performance + $this->bonus_attendance;
    }

    public function getTotalDeductionsAttribute()
    {
        return $this->deduction_cnss + $this->deduction_advances + $this->deduction_absences;
    }
}