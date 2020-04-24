<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Training
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="wardTrainings")
     */
    private $ward;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="trainerTrainings")
     */
    private $trainer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $repeatsActual;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $repeatsExpect;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $trainedAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Exercise", mappedBy="training", orphanRemoval=true)
     */
    private $exercises;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWard(): ?User
    {
        return $this->ward;
    }

    public function setWard(?User $ward): self
    {
        $this->ward = $ward;

        return $this;
    }

    public function getTrainer(): ?User
    {
        return $this->trainer;
    }

    public function setTrainer(?User $trainer): self
    {
        $this->trainer = $trainer;

        return $this;
    }

    public function getRepeatsActual(): ?int
    {
        return $this->repeatsActual;
    }

    public function setRepeatsActual(?int $repeatsActual): self
    {
        $this->repeatsActual = $repeatsActual;

        return $this;
    }

    public function getRepeatsExpect(): ?int
    {
        return $this->repeatsExpect;
    }

    public function setRepeatsExpect(?int $repeatsExpect): self
    {
        $this->repeatsExpect = $repeatsExpect;

        return $this;
    }

    public function getTrainedAt(): ?\DateTimeInterface
    {
        return $this->trainedAt;
    }

    public function setTrainedAt(\DateTimeInterface $trainedAt): self
    {
        $this->trainedAt = $trainedAt;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

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
            $exercise->setTraining($this);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): self
    {
        if ($this->exercises->contains($exercise)) {
            $this->exercises->removeElement($exercise);
            // set the owning side to null (unless already changed)
            if ($exercise->getTraining() === $this) {
                $exercise->setTraining(null);
            }
        }

        return $this;
    }
}
