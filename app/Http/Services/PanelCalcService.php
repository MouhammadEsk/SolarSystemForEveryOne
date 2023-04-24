<?php

namespace App\Http\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class PanelCalcService
{
    private $panelWatt;
    private $batteryVoltag;
    private $batteryAmber;
    private $sunAvgHours;
    private $totalWhatt;
    private $batteryNumber;

    public function __construct($panelWatt, $batteryVoltag, $batteryAmber, $sunAvgHours, $totalWhatt, $batteryNumber)
    {
        $this->panelWatt = $panelWatt;
        $this->batteryVoltag = $batteryVoltag;
        $this->batteryAmber = $batteryAmber;
        $this->sunAvgHours = $sunAvgHours;
        $this->totalWhatt = $totalWhatt;
        $this->batteryNumber = $batteryNumber;
    }

   public function getNumberOfPanels()
   {
       $factor = ($this->batteryNumber * $this->batteryVoltag * $this->batteryAmber)/$this->sunAvgHours;
       $neededPanels = ($this->addPrecntag($this->totalWhatt,0.2) + $factor)/($this->panelWatt * $this->sunAvgHours);
       return round($neededPanels);
   }

    function addPrecntag($num, $alpha) {
        return $num+($num*$alpha);
    }
}
