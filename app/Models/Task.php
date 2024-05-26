<?php

namespace App\Models;

class Task extends BaseModel
{
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'user_id'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'due_date' => 'string',
        'status' => 'boolean',
        'user_id' => 'string'
    ];
}
