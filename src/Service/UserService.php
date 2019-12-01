<?php

namespace App\Service;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    private $registry;

    public function __construct(ValidatorInterface $validator, ManagerRegistry $registry)
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

        $user = new User();
        $user->setEmail($email);
        $apiToken = new ApiToken($user);

        $em = $this->registry->getManager();
        $em->persist($user);
        $em->persist($apiToken);
        $em->flush();

        return $user;
    }
}