<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saveur extends Model
{
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
}
