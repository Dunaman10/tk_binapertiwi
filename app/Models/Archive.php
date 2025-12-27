<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $fillable = [
        'title',
        'description',
        'created_by',
        'file_path',
        'original_filename',
    ];

}
