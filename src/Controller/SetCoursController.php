<?php

namespace App\Controller;

use App\Entity\Edt;
use App\Repository\EdtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SetCoursController extends AbstractController
{
    #[Route('/place-course', name: 'app_set_cours')]
    public function placeCours(
        EdtRepository          $edtRepository,
        EntityManagerInterface $entityManager,
        Request                $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            return $this->json([
                'message' => 'Données manquantes',
            ]);
        }

        $id = $data['id'];
        $time = $data['time'];
        $day = $data['day'];
        $edt = $edtRepository->find($id);

        if (!$edt) {
            return $this->json([
                'message' => 'Cours non trouvé',
            ]);
        }

        $edt->setFlag(Edt::PLACE);
        $edt->setDay($day);
        $edt->setTime($time);
        $entityManager->flush();

        return $this->json($edt->toArray());
    }

    #[Route('/update-room/{id}', name: 'app_update_room', methods: ['POST'])]
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

    #[Route('/remove-course/{id}', name: 'app_delete_course', methods: ['POST'])]
    public function deleteCourse(
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

        $id->setFlag(Edt::NON_PLACE);
        $entityManager->flush();

        return $this->json([
            'message' => 'Cours supprimé',
        ]);
    }
}
