<?php

namespace App\Entity\User;

use App\Entity\Course;
use App\Entity\CourseWork;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\User\StudentRepository")
 */
class Student extends User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Course", inversedBy="students")
     */
    private $courses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CourseWork", mappedBy="student", orphanRemoval=true)
     */
    private $courseWorks;

    public function __construct()
    {
        parent::__construct();
        $this->courses = new ArrayCollection();
        $this->courseWorks = new ArrayCollection();

        $this->setRoles([User::ROLES['student']]);
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return ArrayCollection
     */
    public function getCourseWorks(): ArrayCollection
    {
        return $this->courseWorks;
    }

    public function addCourseWork(CourseWork $courseWork): self
    {
        if (!$this->courseWorks->contains($courseWork)) {
            $this->courseWorks[] = $courseWork;
        }

        return $this;
    }

    public function removeCourseWork(CourseWork $courseWork): self
    {
        if ($this->courseWorks->contains($courseWork)) {
            $this->courseWorks->removeElement($courseWork);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
