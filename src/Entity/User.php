<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_WARD = 'ROLE_WARD';
    const ROLE_TRAINER = 'ROLE_TRAINER';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"search"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"search"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"search"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"search"})
     */
    private $middleName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"search"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Training", mappedBy="trainer")
     */
    private $trainerTrainings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Training", mappedBy="ward")
     */
    private $wardTrainings;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="wards")
     */
    private $trainer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="trainer")
     */
    private $wards;

    public function __construct()
    {
        $this->trainerTrainings = new ArrayCollection();
        $this->wards = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getEmail();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = self::ROLE_USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role)
    {
        $this->roles[] = $role;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(string $middleName): self
    {
        $this->middleName = $middleName;

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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
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
     * @return Collection|Training[]
     */
    public function getTrainerTrainings(): Collection
    {
        return $this->trainerTrainings;
    }

    public function addTrainerTraining(Training $training): self
    {
        if (!$this->trainerTrainings->contains($training)) {
            $this->trainerTrainings[] = $training;
            $training->setTrainer($this);
        }

        return $this;
    }

    public function removeTrainerTraining(Training $training): self
    {
        if ($this->trainerTrainings->contains($training)) {
            $this->trainerTrainings->removeElement($training);
            // set the owning side to null (unless already changed)
            if ($training->getTrainer() === $this) {
                $training->setTrainer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Training[]
     */
    public function getWardTrainings(): Collection
    {
        return $this->wardTrainings;
    }

    public function addWardTraining(Training $training): self
    {
        if (!$this->wardTrainings->contains($training)) {
            $this->wardTrainings[] = $training;
            $training->setWard($this);
        }

        return $this;
    }

    public function removeWardTraining(Training $training): self
    {
        if ($this->wardTrainings->contains($training)) {
            $this->wardTrainings->removeElement($training);
            // set the owning side to null (unless already changed)
            if ($training->getWard() === $this) {
                $training->setWard(null);
            }
        }

        return $this;
    }

    public function getTrainer(): ?self
    {
        return $this->trainer;
    }

    public function setTrainer(?self $trainer): self
    {
        $this->trainer = $trainer;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getWards(): Collection
    {
        return $this->wards;
    }

    public function addWard(self $ward): self
    {
        if (!$this->wards->contains($ward)) {
            $this->wards[] = $ward;
            $ward->setTrainer($this);
        }

        return $this;
    }

    public function removeWard(self $ward): self
    {
        if ($this->wards->contains($ward)) {
            $this->wards->removeElement($ward);
            // set the owning side to null (unless already changed)
            if ($ward->getTrainer() === $this) {
                $ward->setTrainer(null);
            }
        }

        return $this;
    }
}
