<?php

namespace Lib\Cfdi40;

use Lib\Helper;

class Traslado40
{
    public $Base;
    public $Impuesto;
    public $TipoFactor;
    public $TasaOCuota;
    public $Importe;

    public static function getTraslado($traslado)
    {
        try {
            $tras = new Traslado40();
            $tras->Base = Helper::getAttr('Base', $traslado);
            $tras->Impuesto = Helper::getAttr('Impuesto', $traslado);
            $tras->TipoFactor = Helper::getAttr('TipoFactor', $traslado);
            $tras->TasaOCuota = Helper::getAttr('TasaOCuota', $traslado);
            $tras->Importe = Helper::getAttr('Importe', $traslado);
            return $tras;
        } catch (\Exception $e) {
            return null;
        }
    }
}
