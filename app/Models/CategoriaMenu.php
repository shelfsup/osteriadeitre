<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaMenu extends Model
{
    use HasFactory;

    protected $table = 'categorie_menu';

    protected $fillable = [
        'nome_italiano',
        'nome_inglese',
        'enable',
        'ordinamento'
    ];

    public function sottocategorie()
    {
        return $this->hasMany(SottocategoriaMenu::class, 'id_categoria_menu');
    }

    public function piatti()
    {
        return $this->hasMany(PiattoMenu::class, 'id_categoria_menu');
    }

    // CategoriaMenu.php
    public function nome($language)
    {
        return $language == 'en' ? $this->nome_inglese : $this->nome_italiano;
    }

    protected $casts = [
        'enable' => 'boolean',
    ];
}
