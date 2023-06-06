<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
class Employe implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["getEmploye","getDetailEmploye"])]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(["getEmploye","getDetailEmploye"])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getEmploye","getDetailEmploye"])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getEmploye","getDetailEmploye"])]
    private ?string $prenom = null;

    #[ORM\Column]
    #[Groups(["getEmploye","getDetailEmploye"])]
    private ?int $tel = null;

    #[ORM\Column]
    #[Groups(["getEmploye","getDetailEmploye"])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }


    /**
     * @return int|null
     */
    public function getTel(): ?int
    {
        return $this->tel;
    }

    /**
     * @param int|null $tel
     */
    public function setTel(?int $tel): void
    {
        $this->tel = $tel;
    }



    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
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
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
