<?php

namespace App\Units;

class UnitPrice
{
    private float $range_5;
    private float $range_10;
    private float $range_15;
    private float $range_20;
    private float $range_25;
    private float $range_30;

    public function __construct()
    {
        $this->range_5 = 8.0;
        $this->range_10 = 15.0;
        $this->range_15 = 25.0;
        $this->range_20 = 30.0;
        $this->range_25 = 38.65;
        $this->range_30 = 45.0;
    }

    // Getter methods for each range attribute

    public function getRange5()
    {
        return $this->range_5;
    }

    public function getRange10()
    {
        return $this->range_10;
    }

    public function getRange15()
    {
        return $this->range_15;
    }

    public function getRange20()
    {
        return $this->range_20;
    }

    public function getRange25():float
    {
        return $this->range_25;
    }

    public function getRange30():float
    {
        return $this->range_30;
    }

    // Setter methods for each range attribute

    public function setRange5($price)
    {
        $this->range_5 = $price;
    }

    public function setRange10($price)
    {
        $this->range_10 = $price;
    }

    public function setRange15($price)
    {
        $this->range_15 = $price;
    }

    public function setRange20($price)
    {
        $this->range_20 = $price;
    }

    public function setRange25($price)
    {
        $this->range_25 = $price;
    }

    public function setRange30($price)
    {
        $this->range_30 = $price;
    }
}
