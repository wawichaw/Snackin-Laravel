<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = ['utilisateur_id','biscuit_id','quantite','date_commande'];
    protected $casts = ['date_commande' => 'date'];
    public function utilisateur() { return $this->belongsTo(Utilisateur::class); }
    public function biscuit() { return $this->belongsTo(Biscuit::class); }
}
