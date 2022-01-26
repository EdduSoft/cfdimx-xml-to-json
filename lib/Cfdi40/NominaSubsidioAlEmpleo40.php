<?php

namespace Lib\Cfdi40;

use Lib\Helper;

class NominaSubsidioAlEmpleo40
{
    public string $SubsidioCausado = '';

    public function __construct($otroPago)
    {
        try {
            $attributes = [
                'SubsidioCausado'
            ];

            foreach ($attributes as $attribute) {
                $this->$attribute = Helper::getAttr($attribute, $otroPago);
            }

            return $this;
        } catch (\Exception $e) {
            return null;
        }
    }
}