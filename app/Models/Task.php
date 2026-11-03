<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'is_completed'
    ];

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
        ];
    }
}