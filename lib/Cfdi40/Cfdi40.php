<?php

namespace Lib\Cfdi40;

use Lib\Cfdi40\Comprobante40;

class Cfdi40
{
    const VERIFY_CFDI_URL = 'https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx';

    /**
     * Return new empty Comprobante40 object
     *
     * @return Comprobante40
     */
    public static function getComprobante()
    {
        return new Comprobante40();
    }

    /**
     * Convert XML to Cfdi40 version
     *
     * @param [String] $xmlString
     * @return Comprobante40
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
     * @param \Lib\Cfdi40\Comprobante40 $cfdi
     * @return string
     */
    public static function generateVerificationUrl(Comprobante40 $cfdi)
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
