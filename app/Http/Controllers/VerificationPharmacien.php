<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VerificationPharmacien as ModelsVerificationPharmacien;
use Illuminate\Http\Request;

class VerificationPharmacien extends Controller
{
    public function ajout(Request $request)
    {
        $request->validate([
        
    
            'numero_agrement' => 'required|string|max:100',
            'siret' => 'required|string|max:100',
            'nom_pharmacie' => 'nullable|string|max:150',
            'adresse_pharmacie' => 'nullable|string',
            'document_justificatif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Validation pour le fichier
        ]);

        // Gestion du fichier document_justificatif
        if ($request->hasFile('document_justificatif')) {
            $file = $request->file('document_justificatif');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $file->move('documents_justificatifs', $fileName); // Déplace le fichier dans le dossier 'documents_justificatifs'
        } else {
            $fileName = null;
        }

        $verification = ModelsVerificationPharmacien::create([
         
   
            'numero_agrement' => $request->numero_agrement,
            'siret' => $request->siret,
            'nom_pharmacie' => $request->nom_pharmacie,
            'adresse_pharmacie' => $request->adresse_pharmacie,
            'document_justificatif' => $fileName, 
            'statut' => 'en_attente',
            'commentaire_admin' => 'pas encore valide',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Vérification pharmacien ajoutée avec succès.',
            'verification' => $verification,
        ], 201);
    }

    /**
     * Annuler une vérification pharmacien.
     */
    public function annuler($id)
    {
        $verification = ModelsVerificationPharmacien::find($id);

        if (!$verification) {
            return response()->json(['message' => 'Vérification introuvable.'], 404);
        }

        $verification->update(['statut' => 'refuse']);

        return response()->json([
            'message' => 'Vérification annulée avec succès.',
            'verification' => $verification,
        ], 200);
    }

    /**
     * Approuver une vérification pharmacien.
     */
    public function approuver($id)
    {
        $verification = ModelsVerificationPharmacien::find($id);

        if (!$verification) {
            return response()->json(['message' => 'Vérification introuvable.'], 404);
        }

        $verification->update(['statut' => 'valide']);

        return response()->json([
            'message' => 'Vérification approuvée avec succès.',
            'verification' => $verification,
        ], 200);
    }

    // get all verifications
    public function getAll()
    {
        $verifications = ModelsVerificationPharmacien::all();

        return response()->json([
            'message' => 'Toutes les vérifications sont retournées avec succès.',
            'verifications' => $verifications,
        ], 200);
    }
}
