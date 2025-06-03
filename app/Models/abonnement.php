<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class abonnement extends Model
{
    use HasFactory;
    protected $fillable = ['date_debut', 'date_fin', 'status', 'produitID','slaID'];

    protected $attributes = [
        'status' => 'active',
    ];

    public function produit()
{
    return $this->belongsTo(Produit::class, 'produitID'); 
}
    public function getProduit()
    {
        return Produit::find($this->produitID)->nom;
    }

    public function getSla(){
        return Sla::find(
         $this->slaID)->first();
        
    }
  
}
