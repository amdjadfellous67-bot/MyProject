<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->index('department_id');
            $table->index('position_id');
            $table->index('status');
        });

        Schema::table('leave_requests', function (Blueprint $table) {
            $table->index('employee_id');
            $table->index('leave_type_id');
            $table->index('status');
            $table->index(['employee_id', 'status']);
        });

        Schema::table('leave_balances', function (Blueprint $table) {
            $table->index(['employee_id', 'leave_type_id', 'year']);
        });

        Schema::table('salaries', function (Blueprint $table) {
            $table->index(['employee_id', 'month', 'year']);
        });

        Schema::table('evaluations', function (Blueprint $table) {
            $table->index('employee_id');
            $table->index('evaluation_date');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
            $table->index('employee_id');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex(['department_id']);
            $table->dropIndex(['position_id']);
            $table->dropIndex(['status']);
        });
    }
};