<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiattoMenu extends Model
{
    use HasFactory;

    protected $table = 'piatti_menu';

    protected $fillable = [
        'nome_italiano',
        'nome_inglese',
        'descrizione_italiano',
        'descrizione_inglese',
        'prezzo',
        'prezzo_asporto',
        'asporto',
        'solo_asporto',
        'id_categoria_menu',
        'allergeni',
        'surgelato',
        'asporto',
        'prezzo_asporto',
        'ordinamento',
        'solo_asporto',
        'photo',
        'enable',
        'show_desc'
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaMenu::class, 'id_categoria_menu');
    }

    // PiattoMenu.php e PiattoSottocategoria.php
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
        'show_desc' => 'boolean',
        'asporto' => 'boolean',
        'solo_asporto' => 'boolean'
    ];
}
