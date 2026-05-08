<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class InscriptionService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('INSCRIPTION_SERVICE_URL', 'http://inscription:8000');
    }

    /**
     * Vérifie si un utilisateur est inscrit à une formation
     *
     * @param string $userId
     * @param string $formationId
     * @return bool
     */
    public function estInscrit(string $userId, string $formationId): bool
    {
        try {
            $response = Http::timeout(3)->get($this->baseUrl . '/api/enrollments/check', [
                'user_id'      => $userId,
                'formation_id' => $formationId,
            ]);

            if ($response->failed()) {
                return false;
            }

            return (bool) $response->json('inscrit', false);
        } catch (\Exception $e) {
            \Log::error('Erreur appel service inscription: ' . $e->getMessage());
            return false;
        }
    }
}