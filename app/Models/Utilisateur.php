<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $fillable = ['prenom','nom','identifiant','mot_de_passe'];
    protected $hidden = ['mot_de_passe'];
    public function commandes() { return $this->hasMany(Commande::class); }
}
