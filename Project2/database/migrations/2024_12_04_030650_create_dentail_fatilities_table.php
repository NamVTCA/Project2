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
        Schema::create('dentail_fatilities', function (Blueprint $table) {
                  $table->id();
            $table->string('name');
            $table->integer('status');
            $table->integer('quantity');
            $table->foreignId('total_id')->constrained('total_fatilities')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dentail_fatilities');
    }
};