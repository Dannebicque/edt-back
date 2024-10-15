<?php

namespace App\Controller;

use App\Entity\Edt;
use App\Repository\EdtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;

class GetCoursSemaineController extends AbstractController
{
    #[Route('/get-cours-semaine/{numSemaine}', name: 'app_get_cours_semaine')]
    public function index(
        EdtRepository $edtRepository,
        int $numSemaine, KernelInterface $kernel): JsonResponse
    {
        // vérification de la validité du numéro de semaine
        if ($numSemaine < 1 || $numSemaine > 52) {
            return $this->json([
                'message' => 'Numéro de semaine invalide',
            ]);
        }

        $edts = $edtRepository->findAvailableEventsByWeek($numSemaine);
        foreach ($edts as $key => $edt) {
            $edts[$key] = $edt->toArray();
        }

        return $this->json($edts);
    }

    #[Route('/get-placed-courses/{numSemaine}', name: 'app_get_placed_cours_semaine')]
    public function getPlacedCourses(
        EdtRepository $edtRepository,
        int $numSemaine, KernelInterface $kernel): JsonResponse
    {
        // vérification de la validité du numéro de semaine
        if ($numSemaine < 1 || $numSemaine > 52) {
            return $this->json([
                'message' => 'Numéro de semaine invalide',
            ]);
        }

        $events = $edtRepository->findEventsByWeek($numSemaine);

        $tEvents = [];

        /** @var Edt $event */
        foreach ($events as $event) {
            //Lundi_9h30_s3_1
            $key = $event->getDay() . '_' . $event->getTime() . '_' . $event->getSemestre() . '_' . $event->getGroupIndex();
            $tEvents[$key] = $event->toArray();
        }

        return $this->json($tEvents);
    }
}
