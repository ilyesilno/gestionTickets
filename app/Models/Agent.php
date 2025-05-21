<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'support_level',
        'tickets_resolu',
        'tickets_escale'
    ];

    protected $attributes = [
        'tickets_resolu' => 0,
        'tickets_escale' => 0
    ];
  

    

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
   
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
