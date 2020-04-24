<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExerciseRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Exercise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"training_edit", "id"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Training", inversedBy="exercises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $training;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ExerciseType")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"training_edit"})
     */
    private $exerciseType;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ExerciseParameter", mappedBy="exercises")
     * @Groups({"training_edit"})
     */
    private $exerciseParameters;

    public function __construct()
    {
        $this->exerciseParameters = new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->getId();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTime();
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getExerciseType(): ?ExerciseType
    {
        return $this->exerciseType;
    }

    public function setExerciseType(?ExerciseType $exerciseType): self
    {
        $this->exerciseType = $exerciseType;

        return $this;
    }

    /**
     * @return Collection|ExerciseParameter[]
     */
    public function getExerciseParameters(): Collection
    {
        return $this->exerciseParameters;
    }

    public function addExerciseParameter(ExerciseParameter $exerciseParameter): self
    {
        if (!$this->exerciseParameters->contains($exerciseParameter)) {
            $this->exerciseParameters[] = $exerciseParameter;
            $exerciseParameter->addExercise($this);
        }

        return $this;
    }

    public function removeExerciseParameter(ExerciseParameter $exerciseParameter): self
    {
        if ($this->exerciseParameters->contains($exerciseParameter)) {
            $this->exerciseParameters->removeElement($exerciseParameter);
            $exerciseParameter->removeExercise($this);
        }

        return $this;
    }
}
