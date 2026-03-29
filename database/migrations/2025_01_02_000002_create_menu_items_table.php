<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->integer('calories')->nullable();
            $table->enum('category', ['breakfast', 'lunch', 'dinner', 'snack']);
            $table->enum('dietary_type', ['regular', 'vegetarian', 'vegan', 'keto', 'paleo'])->default('regular');
            $table->text('ingredients')->nullable();
            $table->string('image_url', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
