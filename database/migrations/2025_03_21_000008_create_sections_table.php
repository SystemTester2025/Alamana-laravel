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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('قسم جديد');
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->string('sub')->nullable();
            $table->text('desc')->nullable();
            $table->string('key')->unique();  // To identify different sections like hero, features, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
