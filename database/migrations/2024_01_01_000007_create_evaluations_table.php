<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('period');
            $table->date('evaluation_date');
            $table->decimal('score_technical', 5, 2)->default(0);
            $table->text('comment_technical')->nullable();
            $table->decimal('score_behavior', 5, 2)->default(0);
            $table->text('comment_behavior')->nullable();
            $table->decimal('score_objectives', 5, 2)->default(0);
            $table->text('comment_objectives')->nullable();
            $table->decimal('score_punctuality', 5, 2)->default(0);
            $table->text('comment_punctuality')->nullable();
            $table->decimal('overall_score', 5, 2)->default(0);
            $table->foreignId('evaluator_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('path');
            $table->integer('size');
            $table->string('status')->default('completed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('backups');
    }
};