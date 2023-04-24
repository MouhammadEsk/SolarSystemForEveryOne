<?php

namespace App\Http\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class CalculationService
{
    private $totalWhatt;
    private $dayAutomation;
    private $result;
    private $tc;
    private $bv;
    private $Ba;

    //panel
    private $panelwt;
    private $panalesRes;
    private $sunAvgHours;

    public function __construct($totalWhatt, $dayAutomation, $result, $panalesRes, $sunAvgHours)
    {
        $this->totalWhatt = $totalWhatt;
        $this->result = $result;
        $this->dayAutomation = $dayAutomation;

        //panel
        $this->panalesRes = $panalesRes;
        $this->sunAvgHours = $sunAvgHours;

    }

   public function getNumberOfBattares()
   {
       $data = [];
        //batary
       collect($this->result['data'])->each(function ($el1) use (&$data) {
           collect($el1['features'])->each(function ($el) use (&$data) {
               if ($el['name'] === "Type") {
                   $data[] = ['name' => "TC", 'data' => [$el['pivot']['value']]];
               }
               if ($el['name'] === "Ambeer") {
                   $data[] = ['name' => "Ba", 'data' => [$el['pivot']['value']]];
               }
               if ($el['name'] === "Voltage") {
                   $data[] = ['name' => "Bv", 'data' => [$el['pivot']['value']]];
               }
           });
       });

       $result = collect($data)->reduce(function ($acc, $curr) {
           if (!isset($acc[$curr['name']])) {
               $acc[$curr['name']] = [];
           }
           $acc[$curr['name']][] = $curr['data'][0];
           return $acc;
       }, []);

       $this->tc = $result["TC"];
       $this->bv = $result["Bv"];
       $this->Ba = $result["Ba"];

       //panel
       $paneldata = [];
       collect($this->panalesRes['data'])->each(function ($el1) use (&$paneldata) {
           collect($el1['features'])->each(function ($el) use (&$paneldata) {
               if ($el['name'] === "Wattage") {
                   $paneldata[] = ['name' => "TW", 'data' => [$el['pivot']['value']]];
               }
//               dd($el);
           });
       });

       $result2 = collect($paneldata)->reduce(function ($acc, $curr) {
           if (!isset($acc[$curr['name']])) {
               $acc[$curr['name']] = [];
           }
           $acc[$curr['name']][] = $curr['data'][0];
           return $acc;
       }, []);

       $this->panelwt = $result2["TW"];
       $arr = [];
       $panal = [];
       for ($index = 0; $index < 5; $index++) {
           $arr[] = round($this->CalcNumberOfSequance($this->Aha($this->dayAutomation, $index), $index) * $this->NBES($index));
           $panelService = new PanelCalcService($this->panelwt[$index], $this->Ba[$index], $this->bv[$index], $this->sunAvgHours, $this->totalWhatt, $arr[$index]);
           $panal[] = $panelService->getNumberOfPanels();
       }
       $data = [
           'bat' => $arr,
           'panal' => $panal,
       ];
        return  $data;
   }

    function CalcNumberOfSequance($Aha, $i) {
        return $Aha / $this->Ba[$i];
    }

    function getTC($par) {
        $tcTable = ["GEL" => 1.25, "AGM" => 1.2, "FLA" => 1.39];
        return $tcTable[$this->tc[$par]];
    }

    function CalcSystemVoltage($totalWhatt) {
        $convert = ($totalWhatt) + (($totalWhatt)*0.2);
        if ($convert < 1000) {
            return 12;
        }
        if ($convert > 1000 && $convert < 2000) {
            return 24;
        }
        if ($convert > 2000) {
            return 48;
        }
    }

    function Ahd($TCs, $BBV) {
        return $TCs / $BBV;
    }

    function Aha($DA = 1, $par) {
        $precntage = ($this->totalWhatt) * 0.2;
        $AHD = $this->Ahd(($this->totalWhatt) + $precntage, $this->CalcSystemVoltage($this->totalWhatt));
        $TC = $this->getTC($par);
        $mutiply = $AHD * $TC * $DA;
        return $mutiply;
    }

    function NBES($i) {
        $nbs = $this->CalcSystemVoltage($this->totalWhatt) / $this->bv[$i];
        return $nbs;
    }
}
