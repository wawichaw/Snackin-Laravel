<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Biscuit extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nom_biscuit',
        'prix',
        'description',
        'image',
        'saveur_id'
    ];
    
    protected $casts = [
        'prix' => 'decimal:2'
    ];
    
    /**
     * Relation avec la saveur
     */
    public function saveur()
    {
        return $this->belongsTo(Saveur::class);
    }
    
    /**
     * Accessor pour obtenir le nom de la saveur
     */
    public function getNomSaveurAttribute()
    {
        return $this->saveur ? $this->saveur->nom_saveur : 'Saveur inconnue';
    }
}
