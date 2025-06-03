<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceJointe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ticket_id',
        'nom_fichier',
        'chemin',
    ];

    /**
     * Get the ticket that owns the document.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
