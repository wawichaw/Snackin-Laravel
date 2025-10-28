<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commandes';

    protected $fillable = [
        'utilisateur_id',
        'taille_boite',
        'nom_client',
        'email_client',
        'total_prix',
        'details',
        'status',
        // Backwards-compatible fields used by the frontend ordering form
        'client_nom',
        'client_email',
        'details_json',
    ];

    protected $casts = [
        'details' => 'array',
        'details_json' => 'array',
        'total_prix' => 'decimal:2',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\CommandeFactory::new();
    }
}
