<?php

namespace App\Entity\User;

use App\Entity\Course;
use App\Entity\CourseWorkRate;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\User\TeacherRepository")
 */
class Teacher extends User
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Course", inversedBy="teachers")
     */
    private $courses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CourseWorkRate", mappedBy="teacher", orphanRemoval=true)
     */
    private $courseWorkRates;

    public function __construct()
    {
        parent::__construct();
        $this->courses = new ArrayCollection();
        $this->courseWorkRates = new ArrayCollection();

        $this->setRoles([User::ROLES['teacher']]);
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->contains($course)) {
            $this->courses->removeElement($course);
        }

        return $this;
    }

    /**
     * @return Collection|CourseWorkRate[]
     */
    public function getCourseWorkRates(): Collection
    {
        return $this->courseWorkRates;
    }

    public function addCourseWorkRate(CourseWorkRate $courseWorkRate): self
    {
        if (!$this->courseWorkRates->contains($courseWorkRate)) {
            $this->courseWorkRates[] = $courseWorkRate;
        }

        return $this;
    }

    public function removeCourseWorkRate(CourseWorkRate $courseWorkRate): self
    {
        if ($this->courseWorkRates->contains($courseWorkRate)) {
            $this->courseWorkRates->removeElement($courseWorkRate);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
