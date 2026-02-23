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
        Schema::create('class_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['school_class_id', 'user_id']);
        });

        // Migrate existing teacher_id data to pivot table
        $classes = \DB::table('school_classes')->whereNotNull('teacher_id')->get();
        foreach ($classes as $class) {
            \DB::table('class_teacher')->insert([
                'school_class_id' => $class->id,
                'user_id' => $class->teacher_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Drop old teacher_id column
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore teacher_id column
        Schema::table('school_classes', function (Blueprint $table) {
            $table->foreignId('teacher_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });

        // Migrate first teacher back to teacher_id
        $pivotData = \DB::table('class_teacher')
            ->select('school_class_id', 'user_id')
            ->orderBy('id')
            ->get()
            ->unique('school_class_id');

        foreach ($pivotData as $row) {
            \DB::table('school_classes')
                ->where('id', $row->school_class_id)
                ->update(['teacher_id' => $row->user_id]);
        }

        Schema::dropIfExists('class_teacher');
    }
};
