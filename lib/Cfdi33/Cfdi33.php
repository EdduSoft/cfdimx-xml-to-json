<?php

namespace Lib\Cfdi33;

use Lib\Cfdi33\Comprobante33;

class Cfdi33
{
    const VERIFY_CFDI_URL = 'https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx';

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
     * Returns verification url given xml path
     *
     * @param \Lib\Cfdi33\Comprobante33 $cfdi
     * @return string
     */
    public static function generateVerificationUrl(Comprobante33 $cfdi)
    {
        try {
            $verifyUrl = self::VERIFY_CFDI_URL;
            $verifyUrl = $verifyUrl . '?id=' . $cfdi->Complemento->TimbreFiscalDigital->UUID;
            $verifyUrl = $verifyUrl . '&re=' . $cfdi->Emisor->Rfc;
            $verifyUrl = $verifyUrl . '&rr=' . $cfdi->Receptor->Rfc;
            $verifyUrl = $verifyUrl . '&tt=' . $cfdi->Total;
            $verifyUrl = $verifyUrl . '&fe=' . substr($cfdi->Complemento->TimbreFiscalDigital->SelloCFD, -8);    
        } catch (\Exception $e) {
            $verifyUrl = '';
        }
        
        return $verifyUrl;
    }
}
