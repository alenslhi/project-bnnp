<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameWordle extends Model
{
    use HasFactory;

    protected $table = 'game_wordles';

    protected $fillable = [
        'word',
        'length',
        'hint',
        'definition',
        'category',
        'is_active',
    ];

    protected $casts = [
        'length' => 'integer',
        'is_active' => 'boolean',
    ];
}
