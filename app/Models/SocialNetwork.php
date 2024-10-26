<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    use HasFactory;

    protected $table = 'social_networks';

    // Definizione delle colonne modificabili
    protected $fillable = [
        'nome_social',
        'link_profilo',
        'photo',
        'enable',
        'inverti',
    ];

    protected $casts = [
        'enable' => 'boolean',
        'inverti' => 'boolean',
    ];
}
