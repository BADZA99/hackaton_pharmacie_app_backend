<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationPharmacien extends Model
{
    use HasFactory;

    protected $table = 'verifications_pharmaciens';

    protected $fillable = [
        // 'user_id',
        'numero_agrement',
        'siret',
        'nom_pharmacie',
        'adresse_pharmacie',
        'document_justificatif',
        'statut',
        'commentaire_admin',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
  
        'updated_at',
        // 'commentaire_admin',
    ];
}