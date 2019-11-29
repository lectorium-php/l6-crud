<?php

namespace App\Service;

use App\Entity\User;
use App\Security\APIAuthenticator;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var RegistryInterface
     */
    private $registry;

    public function __construct(ValidatorInterface $validator, RegistryInterface $registry)
    {
        $this->validator = $validator;
        $this->registry = $registry;
    }

    public function createApiUser(string $email)
    {
        $violations = $this->validator->validate($email, [
            new Email()
        ]);

        if (!empty($violations)) {
            foreach ($violations as $violation) {
                throw new BadRequestHttpException($violation->getMessage());
            }
        }

        $apiToken = $this->generateToken($email);
        $user = new User();
        $user->setEmail($email);
        $user->setApiToken($apiToken);

        $em = $this->registry->getManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    private function generateToken(string $email)
    {
        return bin2hex($email . random_bytes(60));
    }
}