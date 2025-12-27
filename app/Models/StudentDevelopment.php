<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDevelopment extends Model
{
    protected $table = 'student_development';

    protected $fillable = [
        'student_name',
        'period',
        'score',
        'status',
        'notes',
        'motorik',
        'kognitif',
        'bahasa',
        'sosial_emosional',
    ];

    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_name');
    }
}
