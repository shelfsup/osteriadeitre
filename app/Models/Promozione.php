<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promozione extends Model
{
    use HasFactory;

    protected $table = 'promozioni';

    protected $fillable = ['nome', 'descrizione', 'prezzo'];
}
