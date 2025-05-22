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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
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
