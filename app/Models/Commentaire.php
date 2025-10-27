<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commentaire extends Model
{
    use HasFactory;

    protected $table = 'commentaires';

    protected $fillable = [
        'biscuit_id',
        'utilisateur_id',
        'texte',
        'note',
        'nom_visiteur',
        'email_visiteur',
        'modere',
    ];

    protected $casts = [
        'modere' => 'boolean',
    ];

    public function biscuit()
    {
        return $this->belongsTo(Biscuit::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    /**
     * Obtenir le nom d'affichage du commentateur
     */
    public function getNomAfficheAttribute()
    {
        if ($this->utilisateur_id) {
            return $this->utilisateur->name ?? 'Utilisateur supprimé';
        }
        return $this->nom_visiteur ?? 'Anonyme';
    }
}
