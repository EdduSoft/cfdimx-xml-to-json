<?php

namespace Lib\Cfdi40;

use Lib\Helper;

class NominaPercepcion40
{
    public string $TipoPercepcion = '';
    public string $Clave = '';
    public string $Concepto = '';
    public string $ImporteGravado = '';
    public string $ImporteExento = '';

    public function __construct($percepcion)
    {
        try {
            $attributes = [
                'TipoPercepcion',
                'Clave',
                'Concepto',
                'ImporteGravado',
                'ImporteExento',
            ];

            foreach ($attributes as $attribute) {
                $this->$attribute = Helper::getAttr($attribute, $percepcion);
            }

            return $this;
        } catch (\Exception $e) {
            return null;
        }
    }
}