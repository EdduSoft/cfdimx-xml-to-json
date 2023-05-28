<?php

namespace Lib\Cfdi40;

use Lib\Helper;

class RetencionP40
{
    public $ImpuestoP;
    public $ImporteP;

    public static function getRetencion($retencion)
    {
        try {
            $ret = new RetencionP40();
            $ret->ImpuestoP = Helper::getAttr('ImpuestoP', $retencion);
            $ret->ImporteP = Helper::getAttr('ImporteP', $retencion);
            return $ret;
        } catch (\Exception $e) {
            return null;
        }
    }
}
