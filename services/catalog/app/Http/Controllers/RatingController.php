<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Http\Requests\StoreRatingRequest;
use App\Services\InscriptionService;

class RatingController extends Controller
{
    protected $inscriptionService;

    public function __construct(InscriptionService $inscriptionService)
    {
        $this->inscriptionService = $inscriptionService;
    }

    /**
     * POST /api/formations/{id}/noter
     */
    public function noter(StoreRatingRequest $request, $formationId)
    {
        $userId = $request->user_id;

        // 1. Vérifier l'inscription
        if (!$this->inscriptionService->estInscrit($userId, $formationId)) {
            return response()->json([
                'error' => 'Vous devez être inscrit à cette formation pour la noter'
            ], 403);
        }

        // 2. Vérifier s'il a déjà noté
        $existant = Rating::where('formation_id', $formationId)
                          ->where('user_id', $userId)
                          ->exists();
        if ($existant) {
            return response()->json([
                'error' => 'Vous avez déjà noté cette formation'
            ], 400);
        }

        // 3. Création
        $rating = Rating::create([
            'formation_id' => $formationId,
            'user_id'      => $userId,
            'note'         => $request->note,
            'commentaire'  => $request->commentaire,
        ]);

        return response()->json($rating, 201);
    }

    /**
     * Fonction utilitaire pour enrichir une formation avec moyenne + nb avis
     */
    public static function enrichirAvecNotes($formationId, $formationData = [])
    {
        $moyenne = Rating::moyennePourFormation($formationId);
        $nbAvis  = Rating::nombreAvisPourFormation($formationId);

        $formationData['note_moyenne'] = round($moyenne, 2);
        $formationData['nombre_avis']  = $nbAvis;

        return $formationData;
    }
}