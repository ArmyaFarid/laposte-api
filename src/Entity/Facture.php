<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\Column]
    private ?int $qte_range_5 = null;

    #[ORM\Column]
    private ?int $imp_qte_range_5 = null;

    #[ORM\Column]
    private ?int $imp_prix_range_5 = null;

    #[ORM\Column]
    private ?int $exp_qte_range_5 = null;

    #[ORM\Column]
    private ?int $exp_prix_range_5 = null;

    #[ORM\Column]
    private ?int $imp_qte_range_10 = null;

    #[ORM\Column]
    private ?int $imp_prix_range_10 = null;

    #[ORM\Column]
    private ?int $exp_qte_range_10 = null;

    #[ORM\Column]
    private ?int $exp_prix_range_10 = null;

    #[ORM\Column]
    private ?int $imp_qte_range_15 = null;

    #[ORM\Column]
    private ?int $imp_prix_range_15 = null;

    #[ORM\Column]
    private ?int $exp_qte_range_15 = null;

    #[ORM\Column]
    private ?int $exp_prix_range_15 = null;

    #[ORM\Column]
    private ?int $imp_qte_range_20 = null;

    #[ORM\Column]
    private ?int $imp_prix_range_20 = null;

    #[ORM\Column]
    private ?int $exp_qte_range_20 = null;

    #[ORM\Column]
    private ?int $exp_prix_range_20 = null;

    #[ORM\Column]
    private ?int $imp_qte_range_25 = null;

    #[ORM\Column]
    private ?int $imp_prix_range_25 = null;

    #[ORM\Column]
    private ?int $exp_qte_range_25 = null;

    #[ORM\Column]
    private ?int $exp_prix_range_25 = null;

    #[ORM\Column]
    private ?int $imp_qte_range_30 = null;

    #[ORM\Column]
    private ?int $imp_prix_range_30 = null;

    #[ORM\Column]
    private ?int $exp_qte_range_30 = null;

    #[ORM\Column]
    private ?int $exp_prix_range_30 = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $periode = null;

    #[ORM\Column(length: 13)]
    private ?string $numerofacture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getQteRange5(): ?int
    {
        return $this->qte_range_5;
    }

    public function setQteRange5(int $qte_range_5): self
    {
        $this->qte_range_5 = $qte_range_5;

        return $this;
    }


    public function getImpQteRange5(): ?int
    {
        return $this->imp_qte_range_5;
    }

    public function setImpQteRange5(int $imp_qte_range_5): self
    {
        $this->imp_qte_range_5 = $imp_qte_range_5;

        return $this;
    }

    public function getImpPrixRange5(): ?int
    {
        return $this->imp_prix_range_5;
    }

    public function setImpPrixRange5(int $imp_prix_range_5): self
    {
        $this->imp_prix_range_5 = $imp_prix_range_5;

        return $this;
    }

    public function getExpQteRange5(): ?int
    {
        return $this->exp_qte_range_5;
    }

    public function setExpQteRange5(int $exp_qte_range_5): self
    {
        $this->exp_qte_range_5 = $exp_qte_range_5;

        return $this;
    }

    public function getExpPrixRange5(): ?int
    {
        return $this->exp_prix_range_5;
    }

    public function setExpPrixRange5(int $exp_prix_range_5): self
    {
        $this->exp_prix_range_5 = $exp_prix_range_5;

        return $this;
    }


    public function getImpQteRange10(): ?int
    {
        return $this->imp_qte_range_10;
    }

    public function setImpQteRange10(?int $imp_qte_range_10): self
    {
        $this->imp_qte_range_10 = $imp_qte_range_10;

        return $this;
    }

    public function getImpPrixRange10(): ?int
    {
        return $this->imp_prix_range_10;
    }

    public function setImpPrixRange10(?int $imp_prix_range_10): self
    {
        $this->imp_prix_range_10 = $imp_prix_range_10;

        return $this;
    }

    public function getExpQteRange10(): ?int
    {
        return $this->exp_qte_range_10;
    }

    public function setExpQteRange10(?int $exp_qte_range_10): self
    {
        $this->exp_qte_range_10 = $exp_qte_range_10;

        return $this;
    }

    public function getExpPrixRange10(): ?int
    {
        return $this->exp_prix_range_10;
    }

    public function setExpPrixRange10(?int $exp_prix_range_10): self
    {
        $this->exp_prix_range_10 = $exp_prix_range_10;

        return $this;
    }

// Repeat the same pattern for range_15, range_20, range_25, range_30
// ...
    public function getImpQteRange15(): ?int
    {
        return $this->imp_qte_range_15;
    }

    public function setImpQteRange15(?int $imp_qte_range_15): self
    {
        $this->imp_qte_range_15 = $imp_qte_range_15;

        return $this;
    }

    public function getImpPrixRange15(): ?int
    {
        return $this->imp_prix_range_15;
    }

    public function setImpPrixRange15(?int $imp_prix_range_15): self
    {
        $this->imp_prix_range_15 = $imp_prix_range_15;

        return $this;
    }

    public function getExpQteRange15(): ?int
    {
        return $this->exp_qte_range_15;
    }

    public function setExpQteRange15(?int $exp_qte_range_15): self
    {
        $this->exp_qte_range_15 = $exp_qte_range_15;

        return $this;
    }

    public function getExpPrixRange15(): ?int
    {
        return $this->exp_prix_range_15;
    }

    public function setExpPrixRange15(?int $exp_prix_range_15): self
    {
        $this->exp_prix_range_15 = $exp_prix_range_15;

        return $this;
    }

    public function getImpQteRange20(): ?int
    {
        return $this->imp_qte_range_20;
    }

    public function setImpQteRange20(?int $imp_qte_range_20): self
    {
        $this->imp_qte_range_20 = $imp_qte_range_20;

        return $this;
    }

    public function getImpPrixRange20(): ?int
    {
        return $this->imp_prix_range_20;
    }

    public function setImpPrixRange20(?int $imp_prix_range_20): self
    {
        $this->imp_prix_range_20 = $imp_prix_range_20;

        return $this;
    }

    public function getExpQteRange20(): ?int
    {
        return $this->exp_qte_range_20;
    }

    public function setExpQteRange20(?int $exp_qte_range_20): self
    {
        $this->exp_qte_range_20 = $exp_qte_range_20;

        return $this;
    }

    public function getExpPrixRange20(): ?int
    {
        return $this->exp_prix_range_20;
    }

    public function setExpPrixRange20(?int $exp_prix_range_20): self
    {
        $this->exp_prix_range_20 = $exp_prix_range_20;

        return $this;
    }

    public function getImpQteRange25(): ?int
    {
        return $this->imp_qte_range_25;
    }

    public function setImpQteRange25(?int $imp_qte_range_25): self
    {
        $this->imp_qte_range_25 = $imp_qte_range_25;

        return $this;
    }

    public function getImpPrixRange25(): ?int
    {
        return $this->imp_prix_range_25;
    }

    public function setImpPrixRange25(?int $imp_prix_range_25): self
    {
        $this->imp_prix_range_25 = $imp_prix_range_25;

        return $this;
    }

    public function getExpQteRange25(): ?int
    {
        return $this->exp_qte_range_25;
    }

    public function setExpQteRange25(?int $exp_qte_range_25): self
    {
        $this->exp_qte_range_25 = $exp_qte_range_25;

        return $this;
    }

    public function getExpPrixRange25(): ?int
    {
        return $this->exp_prix_range_25;
    }

    public function setExpPrixRange25(?int $exp_prix_range_25): self
    {
        $this->exp_prix_range_25 = $exp_prix_range_25;

        return $this;
    }

    public function getImpQteRange30(): ?int
    {
        return $this->imp_qte_range_30;
    }

    public function setImpQteRange30(?int $imp_qte_range_30): self
    {
        $this->imp_qte_range_30 = $imp_qte_range_30;

        return $this;
    }

    public function getImpPrixRange30(): ?int
    {
        return $this->imp_prix_range_30;
    }

    public function setImpPrixRange30(?int $imp_prix_range_30): self
    {
        $this->imp_prix_range_30 = $imp_prix_range_30;

        return $this;
    }

    public function getExpQteRange30(): ?int
    {
        return $this->exp_qte_range_30;
    }

    public function setExpQteRange30(?int $exp_qte_range_30): self
    {
        $this->exp_qte_range_30 = $exp_qte_range_30;

        return $this;
    }

    public function getExpPrixRange30(): ?int
    {
        return $this->exp_prix_range_30;
    }

    public function setExpPrixRange30(?int $exp_prix_range_30): self
    {
        $this->exp_prix_range_30 = $exp_prix_range_30;

        return $this;
    }




    public function getPeriode(): ?\DateTimeInterface
    {
        return $this->periode;
    }

    public function setPeriode(\DateTimeInterface $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getNumerofacture(): ?string
    {
        return $this->numerofacture;
    }

    public function setNumerofacture(string $numerofacture): self
    {
        $this->numerofacture = $numerofacture;

        return $this;
    }
}
