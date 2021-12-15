<?php

namespace Lib\Cfdi33;

use Lib\Cfdi33\Comprobante33;

class Cfdi33
{
    const VERIFY_CFDI_URL = 'https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx';
    const TFD_11_TEMPLATE = '||**Version**|**UUID**|**FechaTimbrado**|**RfcProvCertif**|**SelloCFD**|**NoCertificadoSAT**|||';

    /**
     * Return new empty Comprobante33 object
     *
     * @return Comprobante33
     */
    public static function getComprobante()
    {
        return new Comprobante33();
    }

    /**
     * Convert XML to Cfdi33 version
     *
     * @param [String] $xmlString
     * @return Comprobante33
     */
    public static function xmlToJson($xmlString)
    {
        try {
            libxml_use_internal_errors(true);
            $DocXML = new \DOMDocument('1.0', 'utf-8');
            $DocXML->preserveWhiteSpace = FALSE;
            $DocXML->loadXML($xmlString);
            $comprobante = self::getComprobante();

            return $comprobante->getObjectXML($DocXML);
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

    /**
     * Returns verification url given xml path
     *
     * @param \Lib\Cfdi33\Comprobante33 $cfdi
     * @return string
     */
    public static function generateVerificationUrl(Comprobante33 $cfdi)
    {
        $verifyUrl = self::VERIFY_CFDI_URL;
        $verifyUrl = $verifyUrl . '?id=' . $cfdi->Complemento->TimbreFiscalDigital->UUID;
        $verifyUrl = $verifyUrl . '&re=' . $cfdi->Emisor->Rfc;
        $verifyUrl = $verifyUrl . '&rr=' . $cfdi->Receptor->Rfc;
        $verifyUrl = $verifyUrl . '&tt=' . $cfdi->Total;
        return $verifyUrl . '&fe=' . substr($cfdi->Complemento->TimbreFiscalDigital->SelloCFD, -8);
    }
}
