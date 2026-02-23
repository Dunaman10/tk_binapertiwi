<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
  use HasFactory;

  protected $fillable = [
    'student_class',
  ];

  public function teachers(): BelongsToMany
  {
    return $this->belongsToMany(User::class, 'class_teacher', 'school_class_id', 'user_id')->withTimestamps();
  }

  /**
   * @deprecated Use teachers() instead
   */
  public function teacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(User::class, 'teacher_id');
  }
}
