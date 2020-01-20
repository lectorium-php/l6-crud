<?php

namespace App\Security\Voter;

use App\Entity\CourseWork;
use App\Entity\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CourseWorkVoter extends Voter
{
    const ACTIONS = [
        'CREATE' => 'CREATE',
        'RATE' => 'RATE'
    ];

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['NEW', 'RATE'])
            && $subject instanceof CourseWork;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (in_array(User::ROLES['admin'], $user->getRoles())) {
            return true;
        }

        switch ($attribute) {
            case self::ACTIONS['CREATE']:
                return  $this->canCreate($user, $subject);
            case self::ACTIONS['RATE']:

                break;
        }

        return false;
    }

    private function canCreate(UserInterface $user, CourseWork $courseWork)
    {
        $course = $courseWork->getCourse();

        if (!$user->getCourses()->contains($course)) {
            return false;
        }

        if (!in_array(User::ROLES['student'], $user->getRoles())) {
            return false;
        }
    }

    private function canRate(UserInterface $user, CourseWork $courseWork)
    {
        $course = $courseWork->getCourse();

        if (!$user->getCourses()->contains($course)) {
            return false;
        }

        if (CourseWork::STATUSES['rated'] === $courseWork->getStatus()) {
            return false;
        }

        if (!in_array(User::ROLES['teacher'], $user->getRoles())) {
            return false;
        }
    }
}
