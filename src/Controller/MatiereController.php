<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class MatiereController extends AbstractController
{
    #[Route('/matieres', name: 'app_matiere')]
    public function index(): JsonResponse
    {
        return $this->json([
            'WR101' => ['code' => 'WR101', 'semestre' => 1, 'label' => 'Anglais'],
            'WR102' => ['code' => 'WR102', 'semestre' => 1, 'label' => 'Espagnol'],
            'WR103' => ['code' => 'WR103', 'semestre' => 1, 'label' => 'Théorie de la comm'],
            'WR104' => ['code' => 'WR104', 'semestre' => 1, 'label' => 'Maths'],
            'WR105' => ['code' => 'WR105', 'semestre' => 1, 'label' => 'Prog'],
            'WR106' => ['code' => 'WR106', 'semestre' => 1, 'label' => 'Dev'],



        ]);
    }
}
