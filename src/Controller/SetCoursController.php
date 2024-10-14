<?php

namespace App\Controller;

use App\Entity\Edt;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SetCoursController extends AbstractController
{
    #[Route('/place-course', name: 'app_set_cours')]
    public function placeCours(
        EntityManagerInterface $entityManager,
        Request                $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            return $this->json([
                'message' => 'Données manquantes',
            ]);
        }

        $edt = new Edt();
        $edt->setDay($data['day']);
        $edt->setSemestre($data['semestre']);
        $edt->setGroupCount($data['groupCount']);
        $edt->setGroupIndex($data['groupIndex']);
        $edt->setMatiere($data['matiere']);
        $edt->setProfesseur($data['professor']);
        $edt->setTime($data['time']);
        $edt->setWeek($data['week']);
        $edt->setColor($data['color']);

        $entityManager->persist($edt);
        $entityManager->flush();

        return $this->json($edt->toArray());
    }

    #[Route('/update-room/{id}', name: 'app_update_room')]
    public function setRoom(
        Edt                    $id,
        EntityManagerInterface $entityManager,
        Request                $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            return $this->json([
                'message' => 'Données manquantes',
            ]);
        }

        $id->setRoom($data['room']);
        $entityManager->flush();

        return $this->json($id->toArray());
    }
}
