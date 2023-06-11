<?php

namespace App\Units;

class FactureDataMaker
{
    private ?string $numerofacture = null;

    private \DateTime $date;

    private \DateTime $periode;

    private int $client_id;
    // Import attributes
    private int $imp_qte_range_5;
    private float $imp_prix_range_5;
    private float $imp_unitprice_range_5;
    private int $imp_qte_range_10;
    private float $imp_prix_range_10;
    private float $imp_unitprice_range_10;
    private int $imp_qte_range_15;
    private float $imp_prix_range_15;
    private float $imp_unitprice_range_15;
    private int $imp_qte_range_20;
    private float $imp_prix_range_20;
    private float $imp_unitprice_range_20;
    private int $imp_qte_range_25;
    private float $imp_prix_range_25;
    private float $imp_unitprice_range_25;
    private int $imp_qte_range_30;
    private float $imp_prix_range_30;
    private float $imp_unitprice_range_30;

    // Export attributes
    private int $exp_qte_range_5;
    private float $exp_prix_range_5;
    private float $exp_unitprice_range_5;
    private int $exp_qte_range_10;
    private float $exp_prix_range_10;
    private float $exp_unitprice_range_10;
    private int $exp_qte_range_15;
    private float $exp_prix_range_15;
    private float $exp_unitprice_range_15;
    private int $exp_qte_range_20;
    private float $exp_prix_range_20;
    private float $exp_unitprice_range_20;
    private int $exp_qte_range_25;
    private float $exp_prix_range_25;
    private float $exp_unitprice_range_25;
    private int $exp_qte_range_30;
    private float $exp_prix_range_30;
    private float $exp_unitprice_range_30;

    private int $total_qte_import;
    private int $total_qte_export;

    private float $total_prix_import;
    private float $total_prix_export;



    public function __construct(array $imports, array $exports, UnitPrice $unitPrice,\DateTime $periode , int $client_id)
    {
        $this->client_id=$client_id;
        $this->date = new \DateTime();

        $this->periode = $periode;


        $this->numerofacture=uniqid();
        // Initialize import quantities
        $this->imp_qte_range_5 = $this->calculateTotalQuantity($imports, 'range_5');
        $this->imp_qte_range_10 = $this->calculateTotalQuantity($imports, 'range_10');
        $this->imp_qte_range_15 = $this->calculateTotalQuantity($imports, 'range_15');
        $this->imp_qte_range_20 = $this->calculateTotalQuantity($imports, 'range_20');
        $this->imp_qte_range_25 = $this->calculateTotalQuantity($imports, 'range_25');
        $this->imp_qte_range_30 = $this->calculateTotalQuantity($imports, 'range_30');

        $this->total_qte_import = $this->imp_qte_range_5 +
            $this->imp_qte_range_10 +
            $this->imp_qte_range_15 +
            $this->imp_qte_range_20 +
            $this->imp_qte_range_25 +
            $this->imp_qte_range_30;


        // Calculate import prices
        $this->imp_prix_range_5 = $this->imp_qte_range_5 * $unitPrice->getRange5();
        $this->imp_prix_range_10 = $this->imp_qte_range_10 * $unitPrice->getRange10();
        $this->imp_prix_range_15 = $this->imp_qte_range_15 * $unitPrice->getRange15();
        $this->imp_prix_range_20 = $this->imp_qte_range_20 * $unitPrice->getRange20();
        $this->imp_prix_range_25 = $this->imp_qte_range_25 * $unitPrice->getRange25();
        $this->imp_prix_range_30 = $this->imp_qte_range_30 * $unitPrice->getRange30();

        $this->total_prix_import = $this->imp_prix_range_5 + $this->imp_prix_range_10 + $this->imp_prix_range_15 + $this->imp_prix_range_20 + $this->imp_prix_range_25 + $this->imp_prix_range_30;


        // Initialize import unit prices
        $this->imp_unitprice_range_5 = $unitPrice->getRange5();
        $this->imp_unitprice_range_10 = $unitPrice->getRange10();
        $this->imp_unitprice_range_15 = $unitPrice->getRange15();
        $this->imp_unitprice_range_20 = $unitPrice->getRange20();
        $this->imp_unitprice_range_25 = $unitPrice->getRange25();
        $this->imp_unitprice_range_30 = $unitPrice->getRange30();

        // Initialize export quantities
        $this->exp_qte_range_5 = $this->calculateTotalQuantity($exports, 'range_5');
        $this->exp_qte_range_10 = $this->calculateTotalQuantity($exports, 'range_10');
        $this->exp_qte_range_15 = $this->calculateTotalQuantity($exports, 'range_15');
        $this->exp_qte_range_20 = $this->calculateTotalQuantity($exports, 'range_20');
        $this->exp_qte_range_25 = $this->calculateTotalQuantity($exports, 'range_25');
        $this->exp_qte_range_30 = $this->calculateTotalQuantity($exports, 'range_30');

        $this->total_qte_export = $this->exp_qte_range_5 + $this->exp_qte_range_10 + $this->exp_qte_range_15 + $this->exp_qte_range_20 + $this->exp_qte_range_25 + $this->exp_qte_range_30;

        // Calculate export prices
        $this->exp_prix_range_5 = $this->exp_qte_range_5 * $unitPrice->getRange5();
        $this->exp_prix_range_10 = $this->exp_qte_range_10 * $unitPrice->getRange10();
        $this->exp_prix_range_15 = $this->exp_qte_range_15 * $unitPrice->getRange15();
        $this->exp_prix_range_20 = $this->exp_qte_range_20 * $unitPrice->getRange20();
        $this->exp_prix_range_25 = $this->exp_qte_range_25 * $unitPrice->getRange25();
        $this->exp_prix_range_30 = $this->exp_qte_range_30 * $unitPrice->getRange30();

        $this->total_prix_export = $this->exp_prix_range_5 + $this->exp_prix_range_10 + $this->exp_prix_range_15 + $this->exp_prix_range_20 + $this->exp_prix_range_25 + $this->exp_prix_range_30;

        // Initialize export unit prices
        $this->exp_unitprice_range_5 = $unitPrice->getRange5();
        $this->exp_unitprice_range_10 = $unitPrice->getRange10();
        $this->exp_unitprice_range_15 = $unitPrice->getRange15();
        $this->exp_unitprice_range_20 = $unitPrice->getRange20();
        $this->exp_unitprice_range_25 = $unitPrice->getRange25();
        $this->exp_unitprice_range_30 = $unitPrice->getRange30();
    }

    private function calculateTotalQuantity(array $data, $key)
    {
        $total = 0;
        foreach ($data as $item) {
            switch ($key) {
                case 'range_5':
                    $total += $item->getRange5();
                    break;
                case 'range_10':
                    $total += $item->getRange10();
                    break;
                case 'range_15':
                    $total += $item->getRange15();
                    break;
                case 'range_20':
                    $total += $item->getRange20();
                    break;
                case 'range_25':
                    $total += $item->getRange25();
                    break;
                case 'range_30':
                    $total += $item->getRange30();
                    break;
                default:
                    // Handle unrecognized key
                    break;
            }
        }
        return $total;
    }

    /**
     * @return float
     */
    public function getImpQteRange5(): float
    {
        return $this->imp_qte_range_5;
    }

    /**
     * @param float $imp_qte_range_5
     */
    public function setImpQteRange5(float $imp_qte_range_5): void
    {
        $this->imp_qte_range_5 = $imp_qte_range_5;
    }

    /**
     * @return float
     */
    public function getImpPrixRange5(): float
    {
        return $this->imp_prix_range_5;
    }

    /**
     * @param float $imp_prix_range_5
     */
    public function setImpPrixRange5(float $imp_prix_range_5): void
    {
        $this->imp_prix_range_5 = $imp_prix_range_5;
    }

    /**
     * @return float
     */
    public function getImpUnitpriceRange5(): float
    {
        return $this->imp_unitprice_range_5;
    }

    /**
     * @param float $imp_unitprice_range_5
     */
    public function setImpUnitpriceRange5(float $imp_unitprice_range_5): void
    {
        $this->imp_unitprice_range_5 = $imp_unitprice_range_5;
    }

    /**
     * @return float
     */
    public function getImpQteRange10(): float
    {
        return $this->imp_qte_range_10;
    }

    /**
     * @param float $imp_qte_range_10
     */
    public function setImpQteRange10(float $imp_qte_range_10): void
    {
        $this->imp_qte_range_10 = $imp_qte_range_10;
    }

    /**
     * @return float
     */
    public function getImpPrixRange10(): float
    {
        return $this->imp_prix_range_10;
    }

    /**
     * @param float $imp_prix_range_10
     */
    public function setImpPrixRange10(float $imp_prix_range_10): void
    {
        $this->imp_prix_range_10 = $imp_prix_range_10;
    }

    /**
     * @return float
     */
    public function getImpUnitpriceRange10(): float
    {
        return $this->imp_unitprice_range_10;
    }

    /**
     * @param float $imp_unitprice_range_10
     */
    public function setImpUnitpriceRange10(float $imp_unitprice_range_10): void
    {
        $this->imp_unitprice_range_10 = $imp_unitprice_range_10;
    }

    /**
     * @return float
     */
    public function getImpQteRange15(): float
    {
        return $this->imp_qte_range_15;
    }

    /**
     * @param float $imp_qte_range_15
     */
    public function setImpQteRange15(float $imp_qte_range_15): void
    {
        $this->imp_qte_range_15 = $imp_qte_range_15;
    }

    /**
     * @return float
     */
    public function getImpPrixRange15(): float
    {
        return $this->imp_prix_range_15;
    }

    /**
     * @param float $imp_prix_range_15
     */
    public function setImpPrixRange15(float $imp_prix_range_15): void
    {
        $this->imp_prix_range_15 = $imp_prix_range_15;
    }

    /**
     * @return float
     */
    public function getImpUnitpriceRange15(): float
    {
        return $this->imp_unitprice_range_15;
    }

    /**
     * @param float $imp_unitprice_range_15
     */
    public function setImpUnitpriceRange15(float $imp_unitprice_range_15): void
    {
        $this->imp_unitprice_range_15 = $imp_unitprice_range_15;
    }

    /**
     * @return float
     */
    public function getImpQteRange20(): float
    {
        return $this->imp_qte_range_20;
    }

    /**
     * @param float $imp_qte_range_20
     */
    public function setImpQteRange20(float $imp_qte_range_20): void
    {
        $this->imp_qte_range_20 = $imp_qte_range_20;
    }

    /**
     * @return float
     */
    public function getImpPrixRange20(): float
    {
        return $this->imp_prix_range_20;
    }

    /**
     * @param float $imp_prix_range_20
     */
    public function setImpPrixRange20(float $imp_prix_range_20): void
    {
        $this->imp_prix_range_20 = $imp_prix_range_20;
    }

    /**
     * @return float
     */
    public function getImpUnitpriceRange20(): float
    {
        return $this->imp_unitprice_range_20;
    }

    /**
     * @param float $imp_unitprice_range_20
     */
    public function setImpUnitpriceRange20(float $imp_unitprice_range_20): void
    {
        $this->imp_unitprice_range_20 = $imp_unitprice_range_20;
    }

    /**
     * @return float
     */
    public function getImpQteRange25(): float
    {
        return $this->imp_qte_range_25;
    }

    /**
     * @param float $imp_qte_range_25
     */
    public function setImpQteRange25(float $imp_qte_range_25): void
    {
        $this->imp_qte_range_25 = $imp_qte_range_25;
    }

    /**
     * @return float
     */
    public function getImpPrixRange25(): float
    {
        return $this->imp_prix_range_25;
    }

    /**
     * @param float $imp_prix_range_25
     */
    public function setImpPrixRange25(float $imp_prix_range_25): void
    {
        $this->imp_prix_range_25 = $imp_prix_range_25;
    }

    /**
     * @return float
     */
    public function getImpUnitpriceRange25(): float
    {
        return $this->imp_unitprice_range_25;
    }

    /**
     * @param float $imp_unitprice_range_25
     */
    public function setImpUnitpriceRange25(float $imp_unitprice_range_25): void
    {
        $this->imp_unitprice_range_25 = $imp_unitprice_range_25;
    }

    /**
     * @return float
     */
    public function getImpQteRange30(): float
    {
        return $this->imp_qte_range_30;
    }

    /**
     * @param float $imp_qte_range_30
     */
    public function setImpQteRange30(float $imp_qte_range_30): void
    {
        $this->imp_qte_range_30 = $imp_qte_range_30;
    }

    /**
     * @return float
     */
    public function getImpPrixRange30(): float
    {
        return $this->imp_prix_range_30;
    }

    /**
     * @param float $imp_prix_range_30
     */
    public function setImpPrixRange30(float $imp_prix_range_30): void
    {
        $this->imp_prix_range_30 = $imp_prix_range_30;
    }

    /**
     * @return float
     */
    public function getImpUnitpriceRange30(): float
    {
        return $this->imp_unitprice_range_30;
    }

    /**
     * @param float $imp_unitprice_range_30
     */
    public function setImpUnitpriceRange30(float $imp_unitprice_range_30): void
    {
        $this->imp_unitprice_range_30 = $imp_unitprice_range_30;
    }

    /**
     * @return float
     */
    public function getExpQteRange5(): float
    {
        return $this->exp_qte_range_5;
    }

    /**
     * @param float $exp_qte_range_5
     */
    public function setExpQteRange5(float $exp_qte_range_5): void
    {
        $this->exp_qte_range_5 = $exp_qte_range_5;
    }

    /**
     * @return float
     */
    public function getExpPrixRange5(): float
    {
        return $this->exp_prix_range_5;
    }

    /**
     * @param float $exp_prix_range_5
     */
    public function setExpPrixRange5(float $exp_prix_range_5): void
    {
        $this->exp_prix_range_5 = $exp_prix_range_5;
    }

    /**
     * @return float
     */
    public function getExpUnitpriceRange5(): float
    {
        return $this->exp_unitprice_range_5;
    }

    /**
     * @param float $exp_unitprice_range_5
     */
    public function setExpUnitpriceRange5(float $exp_unitprice_range_5): void
    {
        $this->exp_unitprice_range_5 = $exp_unitprice_range_5;
    }

    /**
     * @return float
     */
    public function getExpQteRange10(): float
    {
        return $this->exp_qte_range_10;
    }

    /**
     * @param float $exp_qte_range_10
     */
    public function setExpQteRange10(float $exp_qte_range_10): void
    {
        $this->exp_qte_range_10 = $exp_qte_range_10;
    }

    /**
     * @return float
     */
    public function getExpPrixRange10(): float
    {
        return $this->exp_prix_range_10;
    }

    /**
     * @param float $exp_prix_range_10
     */
    public function setExpPrixRange10(float $exp_prix_range_10): void
    {
        $this->exp_prix_range_10 = $exp_prix_range_10;
    }

    /**
     * @return float
     */
    public function getExpUnitpriceRange10(): float
    {
        return $this->exp_unitprice_range_10;
    }

    /**
     * @param float $exp_unitprice_range_10
     */
    public function setExpUnitpriceRange10(float $exp_unitprice_range_10): void
    {
        $this->exp_unitprice_range_10 = $exp_unitprice_range_10;
    }

    /**
     * @return float
     */
    public function getExpQteRange15(): float
    {
        return $this->exp_qte_range_15;
    }

    /**
     * @param float $exp_qte_range_15
     */
    public function setExpQteRange15(float $exp_qte_range_15): void
    {
        $this->exp_qte_range_15 = $exp_qte_range_15;
    }

    /**
     * @return float
     */
    public function getExpPrixRange15(): float
    {
        return $this->exp_prix_range_15;
    }

    /**
     * @param float $exp_prix_range_15
     */
    public function setExpPrixRange15(float $exp_prix_range_15): void
    {
        $this->exp_prix_range_15 = $exp_prix_range_15;
    }

    /**
     * @return float
     */
    public function getExpUnitpriceRange15(): float
    {
        return $this->exp_unitprice_range_15;
    }

    /**
     * @param float $exp_unitprice_range_15
     */
    public function setExpUnitpriceRange15(float $exp_unitprice_range_15): void
    {
        $this->exp_unitprice_range_15 = $exp_unitprice_range_15;
    }

    /**
     * @return float
     */
    public function getExpQteRange20(): float
    {
        return $this->exp_qte_range_20;
    }

    /**
     * @param float $exp_qte_range_20
     */
    public function setExpQteRange20(float $exp_qte_range_20): void
    {
        $this->exp_qte_range_20 = $exp_qte_range_20;
    }

    /**
     * @return float
     */
    public function getExpPrixRange20(): float
    {
        return $this->exp_prix_range_20;
    }

    /**
     * @param float $exp_prix_range_20
     */
    public function setExpPrixRange20(float $exp_prix_range_20): void
    {
        $this->exp_prix_range_20 = $exp_prix_range_20;
    }

    /**
     * @return float
     */
    public function getExpUnitpriceRange20(): float
    {
        return $this->exp_unitprice_range_20;
    }

    /**
     * @param float $exp_unitprice_range_20
     */
    public function setExpUnitpriceRange20(float $exp_unitprice_range_20): void
    {
        $this->exp_unitprice_range_20 = $exp_unitprice_range_20;
    }

    /**
     * @return float
     */
    public function getExpQteRange25(): float
    {
        return $this->exp_qte_range_25;
    }

    /**
     * @param float $exp_qte_range_25
     */
    public function setExpQteRange25(float $exp_qte_range_25): void
    {
        $this->exp_qte_range_25 = $exp_qte_range_25;
    }

    /**
     * @return float
     */
    public function getExpPrixRange25(): float
    {
        return $this->exp_prix_range_25;
    }

    /**
     * @param float $exp_prix_range_25
     */
    public function setExpPrixRange25(float $exp_prix_range_25): void
    {
        $this->exp_prix_range_25 = $exp_prix_range_25;
    }

    /**
     * @return float
     */
    public function getExpUnitpriceRange25(): float
    {
        return $this->exp_unitprice_range_25;
    }

    /**
     * @param float $exp_unitprice_range_25
     */
    public function setExpUnitpriceRange25(float $exp_unitprice_range_25): void
    {
        $this->exp_unitprice_range_25 = $exp_unitprice_range_25;
    }

    /**
     * @return float
     */
    public function getExpQteRange30(): float
    {
        return $this->exp_qte_range_30;
    }

    /**
     * @param float $exp_qte_range_30
     */
    public function setExpQteRange30(float $exp_qte_range_30): void
    {
        $this->exp_qte_range_30 = $exp_qte_range_30;
    }

    /**
     * @return float
     */
    public function getExpPrixRange30(): float
    {
        return $this->exp_prix_range_30;
    }

    /**
     * @param float $exp_prix_range_30
     */
    public function setExpPrixRange30(float $exp_prix_range_30): void
    {
        $this->exp_prix_range_30 = $exp_prix_range_30;
    }

    /**
     * @return float
     */
    public function getExpUnitpriceRange30(): float
    {
        return $this->exp_unitprice_range_30;
    }

    /**
     * @param float $exp_unitprice_range_30
     */
    public function setExpUnitpriceRange30(float $exp_unitprice_range_30): void
    {
        $this->exp_unitprice_range_30 = $exp_unitprice_range_30;
    }

    /**
     * @return float
     */
    public function getTotalQteImport(): float
    {
        return $this->total_qte_import;
    }

    /**
     * @param float $total_qte_import
     */
    public function setTotalQteImport(float $total_qte_import): void
    {
        $this->total_qte_import = $total_qte_import;
    }

    /**
     * @return float
     */
    public function getTotalQteExport(): float
    {
        return $this->total_qte_export;
    }

    /**
     * @param float $total_qte_export
     */
    public function setTotalQteExport(float $total_qte_export): void
    {
        $this->total_qte_export = $total_qte_export;
    }

    /**
     * @return float
     */
    public function getTotalPrixImport(): float
    {
        return $this->total_prix_import;
    }

    /**
     * @param float $total_prix_import
     */
    public function setTotalPrixImport(float $total_prix_import): void
    {
        $this->total_prix_import = $total_prix_import;
    }

    /**
     * @return float
     */
    public function getTotalPrixExport(): float
    {
        return $this->total_prix_export;
    }

    /**
     * @param float $total_prix_export
     */
    public function setTotalPrixExport(float $total_prix_export): void
    {
        $this->total_prix_export = $total_prix_export;
    }

    /**
     * @return string|null
     */
    public function getNumerofacture(): ?string
    {
        return $this->numerofacture;
    }

    /**
     * @param string|null $numerofacture
     * @return FactureDataMaker
     */
    public function setNumerofacture(?string $numerofacture): FactureDataMaker
    {
        $this->numerofacture = $numerofacture;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return FactureDataMaker
     */
    public function setDate(\DateTime $date): FactureDataMaker
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPeriode(): \DateTime
    {
        return $this->periode;
    }

    /**
     * @param \DateTime $periode
     * @return FactureDataMaker
     */
    public function setPeriode(\DateTime $periode): FactureDataMaker
    {
        $this->periode = $periode;
        return $this;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->client_id;
    }

    /**
     * @param int $client_id
     * @return FactureDataMaker
     */
    public function setClientId(int $client_id): FactureDataMaker
    {
        $this->client_id = $client_id;
        return $this;
    }



}