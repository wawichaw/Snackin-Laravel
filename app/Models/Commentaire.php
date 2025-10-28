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
        'contenu',
        'texte',  // Ajouté pour permettre l'utilisation du mutateur
        'auteur_affiche',
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
        // Si auteur_affiche est défini, l'utiliser en priorité
        if (!empty($this->attributes['auteur_affiche'])) {
            return $this->attributes['auteur_affiche'];
        }

        // Sinon, logique de fallback
        if ($this->utilisateur_id) {
            return $this->utilisateur->name ?? 'Utilisateur supprimé';
        }
        return $this->nom_visiteur ?? 'Anonyme';
    }

    /**
     * Accessor for legacy 'texte' attribute used in views and forms.
     * Maps to the database column 'contenu'.
     */
    public function getTexteAttribute()
    {
        return $this->attributes['contenu'] ?? null;
    }

    /**
     * Mutator for legacy 'texte' attribute used by controllers/forms.
     * Writes into the database column 'contenu'.
     */
    public function setTexteAttribute($value)
    {
        $this->attributes['contenu'] = $value;
    }
}
