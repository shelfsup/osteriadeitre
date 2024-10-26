<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PiattiSottoSottocategoria extends Model
{
    use HasFactory;

    // Nome della tabella
    protected $table = 'piatti_sotto_sottocategorie';

    // Campi mass assignable
    protected $fillable = [
        'id_sotto_sottocategoria_menu',
        'photo',
        'nome_italiano',
        'nome_inglese',
        'prezzo',
        'prezzo_asporto',
        'asporto',
        'solo_asporto',
        'descrizione_italiano',
        'descrizione_inglese',
        'surgelato',
        'allergeni',
        'ordinamento',
        'enable',
        'show_desc'
    ];

    // Relazione con la SottoSottocategoriaMenu
    public function sottoSottocategoriaMenu()
    {
        return $this->belongsTo(SottoSottocategoriaMenu::class, 'id_sotto_sottocategoria_menu');
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
