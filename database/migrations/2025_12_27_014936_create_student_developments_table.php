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
        Schema::create('student_development', function (Blueprint $table) {
            $table->id();
            $table->string('student_name')->nullable(); // ref: > students.name
            $table->string('period')->nullable();
            $table->string('score')->nullable();
            $table->string('status')->nullable();
            $table->text('notes')->nullable();
            $table->integer('motorik')->default(0);
            $table->integer('kognitif')->default(0);
            $table->integer('bahasa')->default(0);
            $table->integer('sosial_emosional')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_development');
    }
};
