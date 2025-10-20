<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saveur extends Model
{
    protected $fillable = [
        'nom_saveur',
        'description'
    ];
    
    /**
     * Relation avec les biscuits
     */
    public function biscuits()
    {
        return $this->hasMany(Biscuit::class);
    }
    
    /**
     * Méthode statique pour récupérer le nom par ID (comme dans votre code original)
     */
    public static function getNomById($id)
    {
        $saveur = self::find($id);
        return $saveur ? $saveur->nom_saveur : 'Saveur inconnue';
    }
}
