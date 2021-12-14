<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class TimbreFiscalDigital33
{
    public $Version;
    public $UUID;
    public $FechaTimbrado;
    public $RfcProvCertif;
    public $SelloCFD;
    public $NoCertificadoSAT;
    public $SelloSAT;




    public function __construct($comp)
    {
        try {
            if ($this->getNode($comp) != null) {
                $complemento = $this->getNode($comp);
                $this->Version = Helper::getAttr('Version', $complemento);
                $this->UUID = Helper::getAttr('UUID', $complemento);
                $this->FechaTimbrado = Helper::getAttr('FechaTimbrado', $complemento);
                $this->RfcProvCertif = Helper::getAttr('RfcProvCertif', $complemento);
                $this->SelloCFD = Helper::getAttr('SelloCFD', $complemento);
                $this->NoCertificadoSAT = Helper::getAttr('NoCertificadoSAT', $complemento);
                $this->SelloSAT = Helper::getAttr('SelloSAT', $complemento);
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
            $tim = $complemento->getElementsByTagName('TimbreFiscalDigital');
            return $tim[0];
        } catch (\Exception $e) {
            return null;
        }
    }
}
