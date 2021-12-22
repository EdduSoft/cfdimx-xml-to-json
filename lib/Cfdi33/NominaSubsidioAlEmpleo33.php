<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class NominaSubsidioAlEmpleo33
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