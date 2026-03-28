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
        Schema::create('prisoners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->date('admission_date');
            $table->string('offense');
            $table->string('assigned_cell');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prisoners');
    }
};
