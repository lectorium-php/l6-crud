<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 */
class Admin extends User
{
    public function __construct()
    {
        parent::__construct();

        $this->setRoles([User::ROLES['admin']]);
    }
}
