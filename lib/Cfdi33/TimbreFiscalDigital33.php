<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class TimbreFiscalDigital33
{
    const TFD_11_TEMPLATE = '||**Version**|**UUID**|**FechaTimbrado**|**RfcProvCertif**|**SelloCFD**|**NoCertificadoSAT**|||';

    public $Version;
    public $UUID;
    public $FechaTimbrado;
    public $RfcProvCertif;
    public $SelloCFD;
    public $NoCertificadoSAT;
    public $SelloSAT;
    public string $CadenaOriginalTfd;




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
                $this->CadenaOriginalTfd = self::generateTfdOriginalString($this) ?? '';
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

    /**
     * Generates tfc original string from xml path
     *
     * @param TimbreFiscalDigital33 $timbreFiscalDigital33
     * @return string
     */
    public static function generateTfdOriginalString(TimbreFiscalDigital33 $tfd)
    {
        $tfdString = self::TFD_11_TEMPLATE;
        $tfdString = str_replace('**Version**', $tfd->Version, $tfdString);
        $tfdString = str_replace('**UUID**', $tfd->UUID, $tfdString);
        $tfdString = str_replace('**FechaTimbrado**', $tfd->FechaTimbrado, $tfdString);
        $tfdString = str_replace('**RfcProvCertif**', $tfd->RfcProvCertif, $tfdString);
        $tfdString = str_replace('**SelloCFD**', $tfd->SelloCFD, $tfdString);
        return str_replace('**NoCertificadoSAT**|', $tfd->NoCertificadoSAT, $tfdString);
    }
}
