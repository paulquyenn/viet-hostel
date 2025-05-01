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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number', 10);
            $table->float('area');
            $table->decimal('price', 10, 2);
            $table->decimal('deposit', 10, 2);
            $table->tinyInteger('status')->default(0);
            $table->integer('max_person')->default(1);
            $table->text('utilities')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('building_id')->constrained('buildings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
