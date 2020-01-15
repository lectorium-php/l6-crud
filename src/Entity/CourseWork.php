<?php

namespace App\Entity;

use App\Entity\User\Student;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseWorkRepository")
 */
class CourseWork
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
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Course", inversedBy="courseWorks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CourseWorkRate", mappedBy="courseWork", orphanRemoval=true)
     */
    private $courseWorkRates;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\Student", inversedBy="courseWorks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    public function __construct()
    {
        $this->courseWorkRates = new ArrayCollection();
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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

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
            $courseWorkRate->setCourseWork($this);
        }

        return $this;
    }

    public function removeCourseWorkRate(CourseWorkRate $courseWorkRate): self
    {
        if ($this->courseWorkRates->contains($courseWorkRate)) {
            $this->courseWorkRates->removeElement($courseWorkRate);
            // set the owning side to null (unless already changed)
            if ($courseWorkRate->getCourseWork() === $this) {
                $courseWorkRate->setCourseWork(null);
            }
        }

        return $this;
    }
}
