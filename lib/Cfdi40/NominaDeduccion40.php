<?php

namespace Lib\Cfdi40;

use Lib\Helper;

class NominaDeduccion40
{
    public string $TipoDeduccion = '';
    public string $Clave = '';
    public string $Concepto = '';
    public string $Importe = '';

    public function __construct($deduccion)
    {
        try {
            $attributes = [
                'TipoDeduccion',
                'Clave',
                'Concepto',
                'Importe',
            ];

            foreach ($attributes as $attribute) {
                $this->$attribute = Helper::getAttr($attribute, $deduccion);
            }

            return $this;
        } catch (\Exception $e) {
            return null;
        }
    }
}