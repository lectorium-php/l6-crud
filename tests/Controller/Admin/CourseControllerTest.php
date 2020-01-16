<?php

namespace App\Tests\Admin;

use App\Tests\AppTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseControllerTest extends AppTestCase
{
    public function testAddStudentSuccess()
    {
        $this->client->request(Request::METHOD_GET, '/admin/course/1/add-student');

        $response = $this->client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}