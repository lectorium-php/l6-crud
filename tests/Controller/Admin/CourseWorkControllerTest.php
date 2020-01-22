<?php

namespace App\Tests\Controller\Admin;

use App\Tests\AppTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseWorkControllerTest extends AppTestCase
{
    public function testAddCourseWorkIsAvailable()
    {
        $this->logIn('student1.symfony.lectorium@appcreative.net', 'student1');
        $this->client->request(Request::METHOD_GET, '/admin/course/1/course-work/new');

        $response = $this->client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testAddCourseWorkIsRedirected()
    {
        $this->client->request(Request::METHOD_GET, '/admin/course/1/course-work/new');

        $response = $this->client->getResponse();
        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }
}
