<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Saveur extends Model
{
    use HasFactory;

    protected $table = 'saveurs';

    protected $fillable = [
        'nom_saveur', 'description',
    ];

    public function biscuits()
    {
        return $this->hasMany(Biscuit::class, 'saveur_id');
    }
}
