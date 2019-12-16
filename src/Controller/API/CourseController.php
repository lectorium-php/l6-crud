<?php


namespace App\Controller\API;


use App\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CourseController
 * @package App\Controller\API
 * @Route("/api/courses")
 */
class CourseController extends AbstractController
{
    private $serializer;
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
    /**
     * @param Request $request
     * @Route("/new", methods={"GET"})
     * @return Response
     */
    public function new(Request $request)
    {
        $requestData = json_decode($request->getContent(), true);

        if (!$requestData['title']) {
            return $this->json(['error' => 'Invalid request'], Response::HTTP_BAD_REQUEST);
        }

        $course = new Course();
        $course->setTitle($requestData['title']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($course);
        $em->flush();

        $jsonData = $this->serializer->serialize(
            ['course' => $course ],
            'json'
        );

        return new Response($jsonData, Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}