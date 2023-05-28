<?php

namespace Lib\Cfdi40;

use Lib\Helper;

class RetencionDR40
{
    public $BaseDR;
    public $ImpuestoDR;
    public $TipoFactorDR;
    public $TasaOCuotaDR;
    public $ImporteDR;

    public static function getRetencion($retencion)
    {
        try {
            $ret = new RetencionDR40();
            $ret->BaseDR = Helper::getAttr('BaseDR', $retencion);
            $ret->ImpuestoDR = Helper::getAttr('ImpuestoDR', $retencion);
            $ret->TipoFactorDR = Helper::getAttr('TipoFactorDR', $retencion);
            $ret->TasaOCuotaDR = Helper::getAttr('TasaOCuotaDR', $retencion);
            $ret->ImporteDR = Helper::getAttr('ImporteDR', $retencion);
            return $ret;
        } catch (\Exception $e) {
            return null;
        }
    }
}
