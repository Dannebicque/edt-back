<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ProfessorController extends AbstractController
{
    #[Route('/professors', name: 'app_professor')]
    public function index(): JsonResponse
    {
        return $this->json([
            'DAN' => ['initiales' => 'DAN', 'nom' => 'Annebicque', 'prenom' => 'David'],
            'FME' => ['initiales' => 'FME', 'nom' => 'Métais', 'prenom' => 'François'],
            'JLE' => ['initiales' => 'JLE', 'nom' => 'Lefebvre', 'prenom' => 'Jean'],
            'RHU' => ['initiales' => 'RHU', 'nom' => 'Huguenin', 'prenom' => 'Romain'],
            'PGO' => ['initiales' => 'PGO', 'nom' => 'Gougeon', 'prenom' => 'Pierre'],

        ]);
    }
}
