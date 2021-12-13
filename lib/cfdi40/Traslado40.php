<?php

namespace App\Cfdi40;

use Illuminate\Database\Eloquent\Model;

class Traslado40
{
    public $Base;
    public $Impuesto;
    public $TipoFactor;
    public $TasaOCuota;
    public $Importe;
    
    public static function getTraslado($traslado){
        try{
            $tras = new Traslado40();
            $tras->Base = $traslado->getAttribute('Base');
            $tras->Impuesto = $traslado->getAttribute('Impuesto');
            $tras->TipoFactor = $traslado->getAttribute('TipoFactor');
            $tras->TasaOCuota = $traslado->getAttribute('TasaOCuota');
            $tras->Importe = $traslado->getAttribute('Importe');
            return $tras;
        }catch(\Exception $e){
            return null;
        }       
    }
}
