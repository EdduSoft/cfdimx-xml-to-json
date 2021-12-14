<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class Retencion33
{
    public $Base;
    public $Impuesto;
    public $TipoFactor;
    public $TasaOCuota;
    public $Importe;

    public static function getRetencion($retencion)
    {
        try {
            $ret = new Retencion33();
            $ret->Base = Helper::getAttr('Base', $retencion);
            $ret->Impuesto = Helper::getAttr('Impuesto', $retencion);
            $ret->TipoFactor = Helper::getAttr('TipoFactor', $retencion);
            $ret->TasaOCuota = Helper::getAttr('TasaOCuota', $retencion);
            $ret->Importe = Helper::getAttr('Importe', $retencion);
            return $ret;
        } catch (\Exception $e) {
            return null;
        }
    }
}
