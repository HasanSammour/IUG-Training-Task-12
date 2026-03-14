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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('short_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->string('instructor_name');
            $table->string('duration')->nullable();
            $table->decimal('rating', 3, 1)->default(0);
            $table->integer('total_students')->default(0);
            $table->enum('level', ['beginner', 'intermediate', 'advanced']);
            $table->enum('format', ['online', 'in-person', 'hybrid']);
            $table->string('image_path')->nullable();
            $table->json('tags')->nullable();
            $table->json('requirements')->nullable();
            $table->json('what_you_will_learn')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
