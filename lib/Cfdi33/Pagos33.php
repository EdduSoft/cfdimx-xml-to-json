<?php

namespace Lib\Cfdi33;


use Lib\Cfdi33\Pago33;
use Lib\Helper;

class Pagos33
{
    public $Pago = [];
    public $Version;


    public function __construct($comp)
    {
        try {
            $pago = $this->getNode($comp);
            if ($pago != null) {
                $this->Version = Helper::getAttr('Version', $pago);
                $xmlPagos = $this->getPagos($comp);
                foreach ($xmlPagos as $pag) {
                    array_push($this->Pago, Pago33::getPagos($pag));
                }
                return $this;
            } else {
                return null;
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
