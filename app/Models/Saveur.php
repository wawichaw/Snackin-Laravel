<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saveur extends Model
{
    use HasFactory;
    
    protected $table = 'saveurs';

    protected $fillable = [
        'nom_saveur',
        'description',
        'emoji'
    ];

    // Accessor pour simplifier l'accès au nom
    public function getNomAttribute()
    {
        return $this->nom_saveur;
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\SaveurFactory::new();
    }
}
