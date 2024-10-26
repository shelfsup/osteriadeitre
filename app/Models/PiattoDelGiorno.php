<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiattoDelGiorno extends Model
{
    use HasFactory;

    protected $table = 'piatti_del_giorno';

    protected $fillable = [
        'nome_italiano',
        'nome_inglese',
        'descrizione_italiano',
        'descrizione_inglese',
        'prezzo',
        'allergeni',
        'surgelato',
        'enable'
    ];

    public function nome($language)
    {
        return $language == 'en' ? $this->nome_inglese : $this->nome_italiano;
    }

    public function descrizione($language)
    {
        return $language == 'en' ? $this->descrizione_inglese : $this->descrizione_italiano;
    }

    protected $casts = [
        'enable' => 'boolean',
        'surgelato' => 'boolean',
    ];
}
