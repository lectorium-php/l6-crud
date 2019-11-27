<?php

namespace App\Controller\API;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/register", methods={"POST"})
     */
    public function register(Request $request, UserService $userService)
    {
        $requestContent = json_decode($request->getContent(), true);

        if (!$requestContent['email']) {
            return $this->json(['error' => 'Invalid request', Response::HTTP_BAD_REQUEST]);
        }

        $user = $userService->createApiUser($requestContent['email']);

        return $this->json([
            'api_token' => $user->getApiToken()
        ]);
    }
}