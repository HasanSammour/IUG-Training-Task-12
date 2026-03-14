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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->string('status')->default('new'); // new, in_progress, responded, closed, spam
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->text('response')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->foreignId('response_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('category')->default('general'); // general, course, technical, billing, feedback, other
            $table->string('priority')->default('normal'); // low, normal, high, urgent
            $table->timestamps();

            $table->index('status');
            $table->index('priority');
            $table->index('category');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};