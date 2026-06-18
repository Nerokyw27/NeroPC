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
        Schema::create('pcs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pc')->unique();
            $table->string('nama_pc');
            $table->enum('kategori', ['ENTRY LEVEL', 'MID RANGE', 'HIGH END']);
            $table->string('prosesor')->nullable();
            $table->string('vga')->nullable();
            $table->string('ram')->nullable();
            $table->string('storage')->nullable();
            $table->string('motherboard')->nullable();
            $table->string('psu')->nullable();
            $table->string('casing')->nullable();
            $table->decimal('harga', 12, 2);
            $table->integer('stok')->default(0);
            $table->boolean('tersedia')->default(true);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcs');
    }
};
