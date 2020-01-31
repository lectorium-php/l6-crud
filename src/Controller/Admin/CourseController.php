<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/course")
 */
class CourseController extends AbstractController
{
    /**
     * @Route("/", name="course_index", methods={"GET"})
     */
    public function index(CourseRepository $courseRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $courseRepository->getAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            $this->getParameter('knp_paginator.page_range') /*limit per page*/
        );

        return $this->render('course/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="course_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('course_index');
        }

        return $this->render('course/new.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="course_show", methods={"GET"})
     */
    public function show(Course $course): Response
    {
        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="course_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Course $course): Response
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('course_index');
        }

        return $this->render('course/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="course_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Course $course): Response
    {
        if ($this->isCsrfTokenValid('delete'.$course->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($course);
            $entityManager->flush();
        }

        return $this->redirectToRoute('course_index');
    }

    /**
     * @Route("/{id}/add-student", name="course_add_student", methods={"GET","POST"})
     * @IsGranted("ADD_STUDENT", subject="course")
     */
    public function addStudent(Request $request, Course $course)
    {
        $form = $this->createForm(CourseType::class, $course, ['add_student' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('course_add_student', ['id' => $course->getId()]);
        }

        return $this->render('course/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }
}
