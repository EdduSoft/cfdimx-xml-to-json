<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class NominaOtroPago
{
    public string $TipoOtroPago = '';
    public string $Clave = '';
    public string $Concepto = '';
    public string $Importe = '';

    public function __construct($otroPago)
    {
        try {
            $attributes = [
                'TipoOtroPago',
                'Clave',
                'Concepto',
                'Importe'
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