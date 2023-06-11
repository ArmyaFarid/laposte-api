<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getDetailFacture",'getFacture'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(["getDetailFacture",'getFacture'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["getDetailFacture",'getFacture'])]
    private ?Client $client = null;



    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?int $imp_qte_range_5 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?float $imp_prix_range_5 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?int $exp_qte_range_5 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?float $exp_prix_range_5 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?int $imp_qte_range_10 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?float $imp_prix_range_10 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?int $exp_qte_range_10 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?float $exp_prix_range_10 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?int $imp_qte_range_15 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?float $imp_prix_range_15 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?int $exp_qte_range_15 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?float $exp_prix_range_15 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?int $imp_qte_range_20 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?float $imp_prix_range_20 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?int $exp_qte_range_20 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?float $exp_prix_range_20 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?int $imp_qte_range_25 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?float $imp_prix_range_25 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?int $exp_qte_range_25 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?float $exp_prix_range_25 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?int $imp_qte_range_30 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?float $imp_prix_range_30 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?int $exp_qte_range_30 = null;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private ?float $exp_prix_range_30 = null;


    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $exp_unitprice_range_5;
    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $exp_unitprice_range_15;
    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $exp_unitprice_range_10;
    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $exp_unitprice_range_20;
    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $exp_unitprice_range_25;
    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $exp_unitprice_range_30;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $imp_unitprice_range_5;
    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $imp_unitprice_range_10;
    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $imp_unitprice_range_15;
    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $imp_unitprice_range_20;
    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $imp_unitprice_range_25;
    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $imp_unitprice_range_30;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $total_qte_import;
    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $total_qte_export;
    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $total_prix_import;
    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $total_prix_export;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $prix_global;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $remise;

    #[ORM\Column]
     #[Groups(["getDetailFacture"])]
    private float $prix_global_net;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(["getDetailFacture"])]
    private ?\DateTimeInterface $periode = null;

    #[ORM\Column(length: 13)]
    #[Groups(["getDetailFacture","getFacture"])]
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

    public function getImpQteRange5(): ?int
    {
        return $this->imp_qte_range_5;
    }

    public function setImpQteRange5(int $imp_qte_range_5): self
    {
        $this->imp_qte_range_5 = $imp_qte_range_5;

        return $this;
    }

    public function getImpPrixRange5(): ?float
    {
        return $this->imp_prix_range_5;
    }

    public function setImpPrixRange5(float $imp_prix_range_5): self
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

    public function getExpPrixRange5(): ?float
    {
        return $this->exp_prix_range_5;
    }

    public function setExpPrixRange5(float $exp_prix_range_5): self
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

    public function getImpPrixRange10(): ?float
    {
        return $this->imp_prix_range_10;
    }

    public function setImpPrixRange10(?float $imp_prix_range_10): self
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

    public function getExpPrixRange10(): ?float
    {
        return $this->exp_prix_range_10;
    }

    public function setExpPrixRange10(?float $exp_prix_range_10): self
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

    public function getImpPrixRange15(): ?float
    {
        return $this->imp_prix_range_15;
    }

    public function setImpPrixRange15(?float $imp_prix_range_15): self
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

    public function getExpPrixRange15(): ?float
    {
        return $this->exp_prix_range_15;
    }

    public function setExpPrixRange15(?float $exp_prix_range_15): self
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

    public function getImpPrixRange20(): ?float
    {
        return $this->imp_prix_range_20;
    }

    public function setImpPrixRange20(?float $imp_prix_range_20): self
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

    public function getExpPrixRange20(): ?float
    {
        return $this->exp_prix_range_20;
    }

    public function setExpPrixRange20(?float $exp_prix_range_20): self
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

    public function getImpPrixRange25(): ?float
    {
        return $this->imp_prix_range_25;
    }

    public function setImpPrixRange25(?float $imp_prix_range_25): self
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

    public function getExpPrixRange25(): ?float
    {
        return $this->exp_prix_range_25;
    }

    public function setExpPrixRange25(?float $exp_prix_range_25): self
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

    public function getImpPrixRange30(): ?float
    {
        return $this->imp_prix_range_30;
    }

    public function setImpPrixRange30(?float $imp_prix_range_30): self
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

    public function getExpPrixRange30(): ?float
    {
        return $this->exp_prix_range_30;
    }

    public function setExpPrixRange30(?float $exp_prix_range_30): self
    {
        $this->exp_prix_range_30 = $exp_prix_range_30;

        return $this;
    }



    public function getExpUnitpriceRange5(): ?float
    {
        return $this->exp_unitprice_range_5;
    }

    public function setExpUnitpriceRange5(?float $exp_unitprice_range_5): self
    {
        $this->exp_unitprice_range_5 = $exp_unitprice_range_5;

        return $this;
    }

    public function getExpUnitpriceRange15(): ?float
    {
        return $this->exp_unitprice_range_15;
    }

    public function setExpUnitpriceRange15(?float $exp_unitprice_range_15): self
    {
        $this->exp_unitprice_range_15 = $exp_unitprice_range_15;

        return $this;
    }

    public function getExpUnitpriceRange10(): ?float
    {
        return $this->exp_unitprice_range_10;
    }

    public function setExpUnitpriceRange10(?float $exp_unitprice_range_10): self
    {
        $this->exp_unitprice_range_10 = $exp_unitprice_range_10;

        return $this;
    }

    public function getExpUnitpriceRange20(): ?float
    {
        return $this->exp_unitprice_range_20;
    }

    public function setExpUnitpriceRange20(?float $exp_unitprice_range_20): self
    {
        $this->exp_unitprice_range_20 = $exp_unitprice_range_20;

        return $this;
    }

    public function getExpUnitpriceRange25(): ?float
    {
        return $this->exp_unitprice_range_25;
    }

    public function setExpUnitpriceRange25(?float $exp_unitprice_range_25): self
    {
        $this->exp_unitprice_range_25 = $exp_unitprice_range_25;

        return $this;
    }

    public function getExpUnitpriceRange30(): ?float
    {
        return $this->exp_unitprice_range_30;
    }

    public function setExpUnitpriceRange30(?float $exp_unitprice_range_30): self
    {
        $this->exp_unitprice_range_30 = $exp_unitprice_range_30;

        return $this;
    }

    public function getImpUnitpriceRange5(): ?float
    {
        return $this->imp_unitprice_range_5;
    }

    public function setImpUnitpriceRange5(?float $imp_unitprice_range_5): self
    {
        $this->imp_unitprice_range_5 = $imp_unitprice_range_5;

        return $this;
    }

    public function getImpUnitpriceRange10(): ?float
    {
        return $this->imp_unitprice_range_10;
    }

    public function setImpUnitpriceRange10(?float $imp_unitprice_range_10): self
    {
        $this->imp_unitprice_range_10 = $imp_unitprice_range_10;

        return $this;
    }

    public function getImpUnitpriceRange15(): ?float
    {
        return $this->imp_unitprice_range_15;
    }

    public function setImpUnitpriceRange15(?float $imp_unitprice_range_15): self
    {
        $this->imp_unitprice_range_15 = $imp_unitprice_range_15;

        return $this;
    }

    public function getImpUnitpriceRange20(): ?float
    {
        return $this->imp_unitprice_range_20;
    }

    public function setImpUnitpriceRange20(?float $imp_unitprice_range_20): self
    {
        $this->imp_unitprice_range_20 = $imp_unitprice_range_20;

        return $this;
    }

    public function getImpUnitpriceRange25(): ?float
    {
        return $this->imp_unitprice_range_25;
    }

    public function setImpUnitpriceRange25(?float $imp_unitprice_range_25): self
    {
        $this->imp_unitprice_range_25 = $imp_unitprice_range_25;

        return $this;
    }

    public function getImpUnitpriceRange30(): ?float
    {
        return $this->imp_unitprice_range_30;
    }

    public function setImpUnitpriceRange30(?float $imp_unitprice_range_30): self
    {
        $this->imp_unitprice_range_30 = $imp_unitprice_range_30;

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

    public function getTotalQteImport(): ?int
    {
        return $this->total_qte_import;
    }

    public function setTotalQteImport(int $total_qte_import): self
    {
        $this->total_qte_import = $total_qte_import;

        return $this;
    }

    public function getTotalQteExport(): ?int
    {
        return $this->total_qte_export;
    }

    public function setTotalQteExport(int $total_qte_export): self
    {
        $this->total_qte_export = $total_qte_export;

        return $this;
    }

    public function getTotalPrixImport(): ?float
    {
        return $this->total_prix_import;
    }

    public function setTotalPrixImport(float $total_prix_import): self
    {
        $this->total_prix_import = $total_prix_import;

        return $this;
    }

    public function getTotalPrixExport(): ?float
    {
        return $this->total_prix_export;
    }

    public function setTotalPrixExport(float $total_prix_export): self
    {
        $this->total_prix_export = $total_prix_export;

        return $this;
    }

    public function getPrixGlobal(): ?float
    {
        return $this->prix_global;
    }

    public function setPrixGlobal(?float $prix_global): self
    {
        $this->prix_global = $prix_global;

        return $this;
    }

    public function getRemise(): ?float
    {
        return $this->remise;
    }

    public function setRemise(?float $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getPrixGlobalNet(): ?float
    {
        return $this->prix_global_net;
    }

    public function setPrixGlobalNet(?float $prix_global_net): self
    {
        $this->prix_global_net = $prix_global_net;

        return $this;
    }

}
