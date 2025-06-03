<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'user_id'];

    public function getClient(){
        return User::find($this->user_id)->nom_complet;
    }

   

}
