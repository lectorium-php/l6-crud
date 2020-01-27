<?php

namespace App\Controller\API;

use App\Repository\User\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;

/**
 * @Route("/teachers")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns the whole list of teachers"
     * )
     * @Security(name="Bearer")
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