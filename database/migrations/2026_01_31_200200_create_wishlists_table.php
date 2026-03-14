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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->integer('priority')->default(2); // 1=low, 2=medium, 3=high, 4=urgent
            $table->date('reminder_date')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
            $table->index('priority');
            $table->index('reminder_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
