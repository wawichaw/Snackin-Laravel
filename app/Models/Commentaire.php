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
    ];

    public function biscuit()
    {
        return $this->belongsTo(Biscuit::class);
    }
}
