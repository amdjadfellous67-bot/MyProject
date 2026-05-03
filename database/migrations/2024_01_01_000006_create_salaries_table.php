<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->decimal('gross_salary', 10, 2)->default(0);
            $table->decimal('bonus_seniority', 10, 2)->default(0);
            $table->decimal('bonus_performance', 10, 2)->default(0);
            $table->decimal('bonus_attendance', 10, 2)->default(0);
            $table->decimal('deduction_cnss', 10, 2)->default(0);
            $table->decimal('deduction_advances', 10, 2)->default(0);
            $table->decimal('deduction_absences', 10, 2)->default(0);
            $table->decimal('net_salary', 10, 2)->default(0);
            $table->string('month');
            $table->year('year');
            $table->timestamps();
            $table->unique(['employee_id', 'month', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};