<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commentaire extends Model
{
    use SoftDeletes;
    protected $fillable = ['biscuit_id','contenu','auteur_affiche'];
    public function biscuit() { return $this->belongsTo(Biscuit::class); }
}
