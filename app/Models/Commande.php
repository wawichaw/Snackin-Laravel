<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commandes';

    protected $fillable = [
        'taille_boite',
        'nom_client',
        'email_client',
        'total_prix',
        'details',
        'status',
    ];

    protected $casts = [
        'details' => 'array',
        'total_prix' => 'decimal:2',
    ];
}
