<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;

class GetSemaineController extends AbstractController
{
    #[Route('/get-semaine/{numSemaine}', name: 'app_get_semaine')]
    public function index(int $numSemaine, KernelInterface $kernel): JsonResponse
    {
        // vérification de la validité du numéro de semaine
        if ($numSemaine < 1 || $numSemaine > 52) {
            return $this->json([
                'message' => 'Numéro de semaine invalide',
            ]);
        }

        $directory = $kernel->getProjectDir();
        $filename = $directory . '/public/semaines/semaine_' . $numSemaine . '.json';

        if (!file_exists($filename)) {
            return $this->json([
                'message' => 'Semaine non trouvée',
            ]);
        }

        $semaine = file_get_contents($filename);
        return $this->json(json_decode($semaine));
    }

    #[Route('/get-all-semaines', name: 'app_get_semaines')]
    public function getAllSemaines(KernelInterface $kernel): JsonResponse
    {
        // vérification de la validité du numéro de semaine
        $directory = $kernel->getProjectDir();
        $directory = $directory . '/public/semaines/';

        $tSemaines = [];

        // on parcours tous les fichiers, on récupère le numéro de semaine et on l'ajoute au tableau avec les jours
        foreach (scandir($directory) as $file) {
            if ($file !== '.' && $file !== '..') {
                $semaine = file_get_contents($directory . $file);
                $data = json_decode($semaine, true);
                $tSemaines[$data['week']] = $data;
            }
        }

        return $this->json($tSemaines);
    }
}
