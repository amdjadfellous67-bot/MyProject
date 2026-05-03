<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'period', 'evaluation_date', 'score_technical', 'comment_technical',
        'score_behavior', 'comment_behavior', 'score_objectives', 'comment_objectives',
        'score_punctuality', 'comment_punctuality', 'overall_score', 'evaluator_id'
    ];

    protected $casts = [
        'evaluation_date' => 'date',
        'score_technical' => 'decimal:2',
        'score_behavior' => 'decimal:2',
        'score_objectives' => 'decimal:2',
        'score_punctuality' => 'decimal:2',
        'overall_score' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(Employee::class, 'evaluator_id');
    }
}