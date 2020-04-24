<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExerciseParameterRepository")
 */
class ExerciseParameter
{
    public function __toString()
    {
        return $this->getType()->getName() . ' - ' . $this->getValue();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"training_edit", "id"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"training_edit"})
     */
    private $value;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Exercise", inversedBy="exerciseParameters")
     */
    private $exercises;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ExerciseParameterType")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"training_edit"})
     */
    private $type;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection|Exercise[]
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function addExercise(Exercise $exercise): self
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises[] = $exercise;
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): self
    {
        if ($this->exercises->contains($exercise)) {
            $this->exercises->removeElement($exercise);
        }

        return $this;
    }

    public function getType(): ?ExerciseParameterType
    {
        return $this->type;
    }

    public function setType(?ExerciseParameterType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
