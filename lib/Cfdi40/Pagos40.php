<?php

namespace Lib\Cfdi40;

use Lib\Cfdi40\Pago40;
use Lib\Helper;

class Pagos40
{
    public $Pago = [];
    public ?ComplementoPagoTotales $Totales;
    public $Version;

    public function __construct($comp = null)
    {
        try {
            if (! empty($comp)) {
                $pago = $this->getNode($comp);
                if ($pago != null) {
                    $this->Version = Helper::getAttr('Version', $pago);
                    $this->Totales = ComplementoPagoTotales::getTotales($pago);
                    $xmlPagos = $this->getPagos($comp);
                    foreach ($xmlPagos as $pag) {
                        array_push($this->Pago, Pago40::getPagos($pag));
                    }
                    return $this;
                } else {
                    return null;
                }
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getNode($complemento)
    {
        try {
            $pag = $complemento->getElementsByTagName('Pagos');
            return $pag[0];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getPagos($complemento)
    {
        try {
            $pag = $complemento->getElementsByTagName('Pago');
            return $pag;
        } catch (\Exception $e) {
            return null;
        }
    }
}
