<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseWorkRateRepository")
 */
class CourseWorkRate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $rate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CourseWork", inversedBy="courseWorkRates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $courseWork;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\Teacher", inversedBy="courseWorkRates", cascade={"persist", "remove"})
     */
    private $teacher;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCourseWork(): ?CourseWork
    {
        return $this->courseWork;
    }

    public function setCourseWork(?CourseWork $courseWork): self
    {
        $this->courseWork = $courseWork;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @param mixed $teacher
     */
    public function setTeacher($teacher): void
    {
        $this->teacher = $teacher;
    }

    public function __toString()
    {
        return (string)$this->rate;
    }
}
