<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SottoSottocategoriaMenu extends Model
{
    use HasFactory;

    // Nome della tabella
    protected $table = 'sotto_sottocategorie_menu';

    // Campi mass assignable
    protected $fillable = [
        'id_sottocategoria_menu',
        'ordinamento',
        'nome_italiano',
        'nome_inglese',
        'descrizione_italiano',
        'descrizione_inglese',
        'enable',
    ];

    // Relazione con la SottocategoriaMenu
    public function sottocategoriaMenu()
    {
        return $this->belongsTo(SottocategoriaMenu::class, 'id_sottocategoria_menu');
    }

    // Relazione con i PiattiSottoSottocategorie
    public function piattiSottoSottocategorie()
    {
        return $this->hasMany(PiattiSottoSottocategoria::class, 'id_sotto_sottocategoria_menu');
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
}
