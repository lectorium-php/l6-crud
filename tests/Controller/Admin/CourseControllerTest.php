<?php

namespace App\Tests\Admin;

use App\Tests\AppTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseControllerTest extends AppTestCase
{
    public function testAddStudentIsAvailable()
    {
        $this->logIn('teacher1.symfony.lectorium@appcreative.net', 'teacher1');
        $this->client->request(Request::METHOD_GET, '/admin/course/1/add-student');

//        $this->client->request(Request::METHOD_GET, '/admin/course/1/add-student', [], [], [
//            'PHP_AUTH_USER' => 'teacher1.symfony.lectorium@appcreative.net',
//            'PHP_AUTH_PW'   => 'teacher1',
//        ]);

        $response = $this->client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testAddStudentIsRedirected()
    {
        $this->client->request(Request::METHOD_GET, '/admin/course/1/add-student');

        $response = $this->client->getResponse();
        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function testAddStudentIsForbidden()
    {
        $this->logIn('teacher1.symfony.lectorium@appcreative.net', 'teacher1');
        $this->client->request(Request::METHOD_GET, '/admin/course/2/add-student');

        $response = $this->client->getResponse();
        self::assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}