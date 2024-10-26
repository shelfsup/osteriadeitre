<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergeni extends Model
{
    use HasFactory;

    protected $table = 'allergeni';

    protected $fillable = [
        'nome_italiano',
        'nome_inglese',
        'descrizione',
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
}
