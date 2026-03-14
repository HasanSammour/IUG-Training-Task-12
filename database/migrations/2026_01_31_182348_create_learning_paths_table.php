<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('learning_paths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('total_courses')->default(0);
            $table->integer('completed_courses')->default(0);
            $table->integer('total_weeks')->default(0);
            $table->integer('progress_percentage')->default(0);
            $table->string('next_milestone')->nullable();
            $table->boolean('is_ai_generated')->default(false);
            $table->json('goals')->nullable();
            $table->date('estimated_completion_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_paths');
    }
};
