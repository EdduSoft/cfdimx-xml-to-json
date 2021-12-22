<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class NominaOtroPago33
{
    public string $TipoOtroPago = '';
    public string $Clave = '';
    public string $Concepto = '';
    public string $Importe = '';
    public NominaSubsidioAlEmpleo33 $SubsidioAlEmpleo;   

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
            
            $subsidioAlEmpleoArr = $otroPago->getElementsByTagName('SubsidioAlEmpleo');
            if (count($subsidioAlEmpleoArr) > 0) {
                $this->SubsidioAlEmpleo = new NominaSubsidioAlEmpleo33(
                    $subsidioAlEmpleoArr[0]
                );
            }

            return $this;
        } catch (\Exception $e) {
            return null;
        }
    }
}