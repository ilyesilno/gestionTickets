<?php

namespace App\Models;

use App\Models\User;
use App\Models\Statut;
use App\Models\Priorite;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'sujet',
        'description',
        'user_id',
        'abonnement_id',
        'priorite',
        'statut',
        'categorie',
        'support_level',
        'assigned_to',
        'duree_qualification',
        'duree_resolution',
        'n1_duration',
        'n2_duration',
        'n3_duration',
        'closed_at'
    ];

    protected $attributes = [
        'statut' => 'ouvert',
        'support_level' => 1,
        'duree_qualification' => 0,
        'duree_resolution' => 0,
        'n1_duration' => 0,
        'n2_duration' => 0,
        'n3_duration' => 0,
        'closed_at' => null

    ];


    /* Les Relations */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function abonnement(){
        return $this->belongsTo(abonnement::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function priorite()
    {
        return $this->belongsTo(Priorite::class);
    }

    public function statut()
    {
        return $this->belongsTo(Statut::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    /* Les Méthodes */

    public function getUser()
    {
        return User::find($this->user_id)->nom_complet;
    }
    public function getAssignedTo()
    {
        $user = User::find($this->assigned_to);
        if ($user != null) {
            return $user->nom_complet;
        }
    }

    public function getAbonnement()
    {
        $abonnement = abonnement::find($this->abonnement_id);
        return $abonnement;
    }
    public function getUserEmail()
    {
        return User::find($this->user_id)->email;
    }
    // public function getPriorite()
    // {
    //     return Priorite::find($this->priorite_id)->nom;
    // }
    // public function getStatut()
    // {
    //     return Statut::find($this->statut_id)->nom;
    // }
    // public function getCategorie()
    // {
    //     return Categorie::find($this->categorie_id)->nom;
    // }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function documents()
    {
        // A Ticket can have many PieceJointes (attachments)
        // 'PieceJointe::class' refers to the related model
        // 'ticket_id' is the foreign key on the 'piece_jointes' table
        return $this->hasMany(PieceJointe::class, 'ticket_id', 'id');
        // 'ticket_id' is the foreign key on the 'piece_jointes' table that refers to the 'id' of the 'tickets' table.
        // If your foreign key name on 'piece_jointes' is just 'ticket_id' and the primary key on 'tickets' is 'id',
        // you can often simply use:
        // return $this->hasMany(PieceJointe::class);
        // Laravel will assume the foreign key is 'ticket_id' based on the 'Ticket' model name.
    }
}
