<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statut extends Model
{
    use HasFactory;

    protected $table = 'statuts';

    protected $fillable = [
        'nom'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
