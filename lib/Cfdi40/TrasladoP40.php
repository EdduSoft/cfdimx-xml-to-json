<?php

namespace Lib\Cfdi40;

use Lib\Helper;

class TrasladoP40
{
    public $BaseP;
    public $ImpuestoP;
    public $TipoFactorP;
    public $TasaOCuotaP;
    public $ImporteP;

    public static function getTraslado($traslado)
    {
        try {
            $tras = new TrasladoP40();
            $tras->BaseP = Helper::getAttr('BaseP', $traslado);
            $tras->ImpuestoP = Helper::getAttr('ImpuestoP', $traslado);
            $tras->TipoFactorP = Helper::getAttr('TipoFactorP', $traslado);
            $tras->TasaOCuotaP = Helper::getAttr('TasaOCuotaP', $traslado);
            $tras->ImporteP = Helper::getAttr('ImporteP', $traslado);
            return $tras;
        } catch (\Exception $e) {
            return null;
        }
    }
}
