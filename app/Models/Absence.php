<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'reason',
        'type',
        'deduction_hours',
        'recorded_by',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function recorder()
    {
        return $this->belongsTo(Employee::class, 'recorded_by');
    }
}