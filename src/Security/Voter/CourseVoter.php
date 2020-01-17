<?php

namespace App\Security\Voter;

use App\Entity\Course;
use App\Entity\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CourseVoter extends Voter
{
    const ACTIONS = [
        'ADD_STUDENT' => 'ADD_STUDENT'
    ];

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, self::ACTIONS)
            && $subject instanceof Course;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (in_array(User::ROLES['admin'], $user->getRoles())) {
            return true;
        }

        switch ($attribute) {
            case self::ACTIONS['ADD_STUDENT']:
                return $this->canAddStudent($user, $subject);
                break;
        }

        return false;
    }

    private function canAddStudent(User $user, Course $course)
    {
        if (!$user->getCourses()->contains($course)) {
            return false;
        }

        if (!in_array(User::ROLES['teacher'], $user->getRoles())) {
            return false;
        }

        return true;
    }
}
