<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class NominaPercepcion33
{
    public string $TipoPercepcion = '';
    public string $Clave = '';
    public string $Concepto = '';
    public string $ImporteGravado = '';
    public string $ImporteExento = '';

    public static function getPercepcion($percepcion)
    {
        try {
            $attributes = [
                'TipoPercepcion',
                'Clave',
                'Concepto',
                'ImporteGravado',
                'ImporteExento',
            ];
            
            $nominaPercepcion = new NominaPercepcion33();
            foreach ($attributes as $attribute) {
                $nominaPercepcion->$attribute = Helper::getAttr($attribute, $percepcion);
            }

            return $nominaPercepcion;
        } catch (\Exception $e) {
            return null;
        }
    }
}