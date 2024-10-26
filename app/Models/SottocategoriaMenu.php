<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SottocategoriaMenu extends Model
{
    use HasFactory;

    protected $table = 'sottocategorie_menu';

    protected $fillable = [
        'nome_italiano',
        'nome_inglese',
        'descrizione_italiano',
        'descrizione_inglese',
        'id_categoria_menu',
        'enable',
        'ordinamento'
    ];

    public function piattiSottocategorie()
    {
        return $this->hasMany(PiattoSottocategoria::class, 'id_sottocategoria_menu');
    }

    public function sottoSottocategorie()
    {
        return $this->hasMany(SottoSottocategoriaMenu::class, 'id_sottocategoria_menu');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaMenu::class, 'id_categoria_menu');
    }

    // PiattoMenu.php e PiattoSottocategoria.php
    public function nome($language)
    {
        return $language == 'en' ? $this->nome_inglese : $this->nome_italiano;
    }

    protected $casts = [
        'enable' => 'boolean',
    ];
}
