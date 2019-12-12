<?php

namespace App\Controller\API;

use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/teachers")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function list(TeacherRepository $repository)
    {
        $teachers = array_map(function($teacher) {
            return [
                'id' => $teacher->getId(),
                'email' => $teacher->getEmail(),
                'first_name' => $teacher->getFirstName(),
                'last_name' => $teacher->getLastName(),
                'course' => $teacher->getCourse()->getTitle()
            ];
        }, $repository->findAll());

        return $this->json([
            'teachers' => $teachers
        ]);
    }
}