<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Priorite extends Model
{
    use HasFactory;

    protected $table = 'priorites';

    protected $fillable = [
        'nom'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
