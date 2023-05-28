<?php

namespace Lib\Cfdi40;

use Lib\Helper;

class TrasladoDR40
{
    public $BaseDR;
    public $ImpuestoDR;
    public $TipoFactorDR;
    public $TasaOCuotaDR;
    public $ImporteDR;

    public static function getTraslado($traslado)
    {
        try {
            $tras = new TrasladoDR40();
            $tras->BaseDR = Helper::getAttr('BaseDR', $traslado);
            $tras->ImpuestoDR = Helper::getAttr('ImpuestoDR', $traslado);
            $tras->TipoFactorDR = Helper::getAttr('TipoFactorDR', $traslado);
            $tras->TasaOCuotaDR = Helper::getAttr('TasaOCuotaDR', $traslado);
            $tras->ImporteDR = Helper::getAttr('ImporteDR', $traslado);
            return $tras;
        } catch (\Exception $e) {
            return null;
        }
    }
}
