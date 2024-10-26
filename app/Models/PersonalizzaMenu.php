<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalizzaMenu extends Model
{
    use HasFactory;

    protected $table = 'personalizza_menu';

    // Definizione delle colonne modificabili
    protected $fillable = [
        'titolo_italiano',
        'titolo_inglese',
        'sottotitolo_italiano',
        'sottotitolo_inglese',
        'titolo_menu_italiano',
        'titolo_menu_inglese',
        'titolo_menu_asporto_italiano',
        'titolo_menu_asporto_inglese',
        'titolo_social_italiano',
        'titolo_social_inglese',
    ];
}
