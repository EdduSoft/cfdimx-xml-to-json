<?php

namespace Lib\Cfdi40;



use Lib\Cfdi40\TimbreFiscalDigital40;
use Lib\Cfdi40\Nomina40;
use Lib\Cfdi40\ComercioExterior40;
use Lib\Cfdi40\Pagos40;
use Lib\Cfdi40\ImpuestosLocales40;

class Complemento40
{

    public ?TimbreFiscalDigital40 $TimbreFiscalDigital;
    public $Nomina;
    public $ComercioExterior;
    public ?Pagos40 $Pagos;
    public $ImpuestosLocales;



    public static function getComplemento($xml)
    {
        try {
            $obj = new Complemento40();
            if ($obj->getNode($xml) != null) {
                $complemento = $obj->getNode($xml);
                $obj->TimbreFiscalDigital = new TimbreFiscalDigital40($complemento);
                $obj->Pagos = new Pagos40($complemento);
                //$obj->Nomina = new Nomina40($complemento);
                //$obj->ComercioExterior = new ComercioExterior40($complemento);
                //$obj->ImpuestosLocales = new ImpuestosLocales40($complememento);




                return $obj;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getNode($xml)
    {
        try {
            $complemento = $xml->getElementsByTagName('Complemento');
            return $complemento[0];
        } catch (\Exception $e) {
            return null;
        }
    }
}
