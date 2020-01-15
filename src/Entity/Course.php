<?php

namespace App\Entity;

use App\Entity\User\Student;
use App\Entity\User\Teacher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 */
class Course
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
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User\Teacher", mappedBy="courses")
     */
    private $teachers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User\Student", mappedBy="courses")
     */
    private $students;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CourseWork", mappedBy="course", orphanRemoval=true)
     */
    private $courseWorks;

    public function __construct()
    {
        $this->teachers = new ArrayCollection();
        $this->students = new ArrayCollection();
        $this->courseWorks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Teacher[]
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function addTeacher(Teacher $teacher): self
    {
        if (!$this->teachers->contains($teacher)) {
            $this->teachers[] = $teacher;
            $teacher->setCourse($this);
        }

        return $this;
    }

    public function removeTeacher(Teacher $teacher): self
    {
        if ($this->teachers->contains($teacher)) {
            $this->teachers->removeElement($teacher);
            // set the owning side to null (unless already changed)
            if ($teacher->getCourse() === $this) {
                $teacher->setCourse(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->addCourse($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            $student->removeCourse($this);
        }

        return $this;
    }

    /**
     * @return Collection|CourseWork[]
     */
    public function getCourseWorks(): Collection
    {
        return $this->courseWorks;
    }

    public function addCourseWork(CourseWork $courseWork): self
    {
        if (!$this->courseWorks->contains($courseWork)) {
            $this->courseWorks[] = $courseWork;
            $courseWork->setCourse($this);
        }

        return $this;
    }

    public function removeCourseWork(CourseWork $courseWork): self
    {
        if ($this->courseWorks->contains($courseWork)) {
            $this->courseWorks->removeElement($courseWork);
            // set the owning side to null (unless already changed)
            if ($courseWork->getCourse() === $this) {
                $courseWork->setCourse(null);
            }
        }

        return $this;
    }

}
