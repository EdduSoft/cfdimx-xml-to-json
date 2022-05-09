<?php

namespace Lib\Cfdi40;

use Lib\Helper;

class NominaOtroPago40
{
    public string $TipoOtroPago = '';
    public string $Clave = '';
    public string $Concepto = '';
    public string $Importe = '';
    public NominaSubsidioAlEmpleo40 $SubsidioAlEmpleo;

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
                $this->SubsidioAlEmpleo = new NominaSubsidioAlEmpleo40(
                    $subsidioAlEmpleoArr[0]
                );
            }

            return $this;
        } catch (\Exception $e) {
            return null;
        }
    }
}