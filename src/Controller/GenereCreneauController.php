<?php

namespace App\Controller;

use App\Entity\Edt;
use App\Entity\Progression;
use App\Repository\ProgressionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GenereCreneauController extends AbstractController
{
    #[Route('/genere-all-creneaux', name: 'app_genere_creneau', methods: ['GET'])]
    public function index(
        EntityManagerInterface $entityManager,
        ProgressionRepository  $progressionRepository): JsonResponse
    {
        //récupérer la progression et générer les créneaux dans l'EDT pour pouvoir les placer ensuite
        $progressions = $progressionRepository->findAll();
        $edts = [];
        foreach ($progressions as $progression) {
            //parcours l'ensemble des créneaux de la progression
            foreach ($progression->getProgression() as $week => $prog) {
                // selon le semestre et le type de cours CM, TD ou TP générer tous les événéments dans EDT
                $seances = explode(' ', $prog);
                dump($seances);
                foreach ($seances as $seance) {
                    dump($seance);
                    $semestre = $progression->getMatiere()?->getSemestre();

                    if ($semestre !== null) {
                        //tester si le créneau est déjà placé
                        //tester si CM, TD ou TP, et le cas échéant générer les créneaux pour chaque groupe, en fonction du semestre
                        if (str_starts_with($seance, 'CM')) {
                            $this->generateEdt($entityManager, $progression, $week, 1, 'CM', $seance);
                        } elseif (str_starts_with($seance, 'TD')) {
                            // parcourir le nombre de groupes soit par défaut si groupeTD est vide, sinon selon ce critère
                            $nbGroupes = $progression->getGrTd();
                            if ($nbGroupes === null) {
                                $nbGroupes = $semestre->getListeGroupesTd();
                            }
                            $nbGroupes = explode(' ', $nbGroupes);

                            foreach ($nbGroupes as $groupe) {
                                dump($groupe);
                                $index = $this->getIndexFromGroupe($groupe);
                                $this->generateEdt($entityManager, $progression, $week, $index, 'TD', $seance);
                            }
                        } elseif (str_starts_with($seance, 'TP')) {
                            // parcourir le nombre de groupes soit par défaut si groupeTD est vide, sinon selon ce critère
                            $nbGroupes = $progression->getGrTp();
                            if ($nbGroupes === null) {
                                $nbGroupes = $semestre->getListeGroupesTp();
                            }
                            $nbGroupes = explode(' ', $nbGroupes);

                            foreach ($nbGroupes as $groupe) {
                                dump($groupe);
                                $index = $this->getIndexFromGroupe($groupe);
                                $this->generateEdt($entityManager, $progression, $week, $index, 'TP', $seance);
                            }
                        }
                    }

                }
            }
            $entityManager->flush();
        }
        return $this->json([
            'message' => 'Créneaux générés',
        ]);
    }

    private function generateEdt(EntityManagerInterface $entityManager, Progression $progression, int|string $week, int $start, string $typeCours, string $seance): void
    {
        $semestre = $progression->getMatiere()?->getSemestre();

        if ($semestre === null) {
            return;
        }

        if ($typeCours === 'CM') {
            $size = $semestre->getSizeCm();
        } elseif ($typeCours === 'TD') {
            $size = 2;
        } elseif ($typeCours === 'TP') {
            $size = 1;
        }


        $edt = new Edt();
        $edt->setDay(null);
        $edt->setSemestre($progression->getMatiere()?->getSemestre());
        $edt->setGroupCount($size);
        $edt->setGroupIndex($start);
        $edt->setMatiere($progression->getMatiere());
        $edt->setProfesseur($progression->getProfesseur());
        $edt->setWeek((int)$week+1);
        $edt->setColor($progression->getMatiere()?->getCouleur());
        $edt->setFlag(Edt::NON_PLACE);
        $edt->setRoom(null);
        $edt->setNumSeance($seance);
        $entityManager->persist($edt);
    }

    private function getIndexFromGroupe(string $groupe): int
    {
        return match ($groupe) {
            'A' => 1,
            'B' => 2,
            'C' => 3,
            'D' => 4,
            'E' => 5,
            'F' => 6,
            'G' => 7,
            'H' => 8,
            'I' => 9,
            'J' => 10,
            'AB' => 1,
            'CD' => 3,
            'EF' => 5,
            'GH' => 7,
            'IJ' => 9,
            default => 1,
        };
    }

}
