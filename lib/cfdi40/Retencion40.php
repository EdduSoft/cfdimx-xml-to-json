<?php

namespace App\Cfdi40;

use Illuminate\Database\Eloquent\Model;

class Retencion40
{
    public $Base;
    public $Impuesto;
    public $TipoFactor;
    public $TasaOCuota;
    public $Importe;
    
    public static function getRetencion($retencion){  
        try{
            $ret = new Retencion40();
            $ret->Base = $retencion->getAttribute('Base');
            $ret->Impuesto = $retencion->getAttribute('Impuesto');
            $ret->TipoFactor = $retencion->getAttribute('TipoFactor');
            $ret->TasaOCuota = $retencion->getAttribute('TasaOCuota');
            $ret->Importe = $retencion->getAttribute('Importe');
            return $ret;
        }catch(\Exception $e){
            return null;
        }
    }    
    
}
