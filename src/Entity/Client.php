<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getTransactions","getClient","getDetailClient"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom est obligatoire")]
    #[Assert\Length(min: 1, max: 255, minMessage: "Le nom doit faire au moins {{ limit }} caractères", maxMessage: "Le nom ne peut pas faire plus de {{ limit }} caractères")]
    #[Groups(["getTransactions","getClient"])]
    private ?string $nom = null;

    #[ORM\Column]
    #[Groups(["getTransactions","getClient"])]
    #[Assert\NotBlank(message: "Le nom est obligatoire")]
    private ?int $tel = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getTransactions","getClient"])]
    #[Assert\NotBlank(message: "Le mail est obligatoire")]
    #[Assert\Regex(
        pattern: '/^\w+@\w+\.\w+$/',
        message: "L'adresse email '{{ value }}' n'est pas valide. Elle doit respecter le format aaa@nom.domain."
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getTransactions","getClient"])]
    #[Assert\NotBlank(message: "L'adresse' est obligatoire")]
    #[Assert\Length(min: 5, minMessage: "L'adresse doit faire au moins {{ limit }} caractères")]
    private ?string $adresse = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Import::class, orphanRemoval: true)]
    #[Groups(["getClient","getDetailClient"])]
    private Collection $imports;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Export::class, orphanRemoval: true)]
    #[Groups(["getClient","getDetailClient"])]
    private Collection $exports;

    public function __construct()
    {
        $this->imports = new ArrayCollection();
        $this->exports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Import>
     */
    public function getImports(): Collection
    {
        return $this->imports;
    }

    public function addImport(Import $import): self
    {
        if (!$this->imports->contains($import)) {
            $this->imports->add($import);
            $import->setClient($this);
        }

        return $this;
    }

    public function removeImport(Import $import): self
    {
        if ($this->imports->removeElement($import)) {
            // set the owning side to null (unless already changed)
            if ($import->getClient() === $this) {
                $import->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Export>
     */
    public function getExports(): Collection
    {
        return $this->exports;
    }

    public function addExport(Export $export): self
    {
        if (!$this->exports->contains($export)) {
            $this->exports->add($export);
            $export->setClient($this);
        }

        return $this;
    }

    public function removeExport(Export $export): self
    {
        if ($this->exports->removeElement($export)) {
            // set the owning side to null (unless already changed)
            if ($export->getClient() === $this) {
                $export->setClient(null);
            }
        }

        return $this;
    }
}
