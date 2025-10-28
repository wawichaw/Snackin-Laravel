<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biscuit extends Model
{
    use HasFactory;

    protected $table = 'biscuits';

    protected $fillable = [
        'nom_biscuit',
        'prix',
        'description',
        'image',
        'saveur_id',
    ];

    public function saveur()
    {
        return $this->belongsTo(Saveur::class, 'saveur_id');
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\BiscuitFactory::new();
    }
}
