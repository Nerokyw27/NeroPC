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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->string('category'); // e.g., Processor, VGA, RAM, Motherboard, PSU, Casing, Storage, Prebuilt PC
            $table->string('brand');
            $table->bigInteger('price');
            $table->integer('stock')->default(0);
            $table->text('description')->nullable();
            $table->json('specifications')->nullable(); // CPU: Clock speed, Cores, Socket. RAM: Size, Speed. etc.
            $table->string('image_path')->nullable();
            $table->boolean('is_recommended')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
