<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMitosFakta extends Model
{
    use HasFactory;

    protected $table = 'game_mitos_faktas';

    protected $fillable = [
        'statement',
        'is_fakta',
        'badge',
        'explanation',
        'clue',
        'is_active',
    ];

    protected $casts = [
        'is_fakta' => 'boolean',
        'is_active' => 'boolean',
    ];
}
