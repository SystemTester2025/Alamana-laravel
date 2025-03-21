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
        Schema::create('section_parts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('sub')->nullable();
            $table->text('desc')->nullable();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('key')->nullable();
            $table->string('value')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_parts');
    }
};
