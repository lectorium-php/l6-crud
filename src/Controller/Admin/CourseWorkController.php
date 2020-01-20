<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Entity\CourseWork;
use App\Entity\CourseWorkRate;
use App\Form\CourseWorkRateType;
use App\Form\CourseWorkType;
use App\Repository\CourseWorkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/course/{course}/course-work")
 */
class CourseWorkController extends AbstractController
{
    /**
     * @Route("/", name="course_work_index", methods={"GET"})
     */
    public function index(CourseWorkRepository $courseWorkRepository, Course $course): Response
    {
        return $this->render('course_work/index.html.twig', [
            'course_works' => $courseWorkRepository->findAll(),
            'course' => $course
        ]);
    }

    /**
     * @Route("/new", name="course_work_new", methods={"GET","POST"})
     * @IsGranted("CREATE", subject="course")
     */
    public function new(Request $request, Course $course): Response
    {
        $user = $this->getUser();
        $courseWork = new CourseWork();
        $courseWork->setCourse($course);
        $courseWork->setStatus(CourseWork::STATUSES['new']);

        $isAdmin = $user->isAdmin();
        if (!$isAdmin) {
            $courseWork->setStudent($user);
        }

        $form = $this->createForm(CourseWorkType::class, $courseWork, ['is_admin' => $isAdmin]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($courseWork);
            $entityManager->flush();

            return $this->redirectToRoute('course_work_index', ['course' => $course->getId()]);
        }

        return $this->render('course_work/new.html.twig', [
            'course_work' => $courseWork,
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="course_work_show", methods={"GET"})
     */
    public function show(Course $course, CourseWork $courseWork): Response
    {
        return $this->render('course_work/show.html.twig', [
            'course' => $course,
            'course_work' => $courseWork,
        ]);
    }

    /**
     * @Route("/{id}/rate", name="course_work_rate", methods={"GET","POST"})
     * @IsGranted("RATE", subject="courseWork")
     */
    public function rate(Request $request, Course $course, CourseWork $courseWork): Response
    {
        $courseWorkRate = new CourseWorkRate();
        $courseWorkRate->setCourseWork($courseWork);

        $form = $this->createForm(CourseWorkRateType::class, $courseWorkRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('course_work_index', ['course' => $course->getId()]);
        }

        return $this->render('course_work/rate.html.twig', [
            'course' => $course,
            'course_work' => $courseWork,
            'form' => $form->createView(),
        ]);
    }
}
