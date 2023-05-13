<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getTransactions","getClient","getDetailClient"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getTransactions","getClient"])]
    private ?string $nom = null;

    #[ORM\Column]
    #[Groups(["getTransactions","getClient"])]
    private ?int $tel = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getTransactions","getClient"])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getTransactions","getClient"])]
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
