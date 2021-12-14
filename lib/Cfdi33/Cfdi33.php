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
     * @param $xmlFile
     * @return string
     */
    public static function generateTfdOriginalString($xmlFile)
    {
        $cfdiData = self::xmlToJson(file_get_contents($xmlFile));
        $tfd = $cfdiData->Complemento->TimbreFiscalDigital ?? false;

        if (!$tfd) return '';

        $tfdString = self::TFD_11_TEMPLATE;
        $tfdString = str_replace('**Version**', $tfd->Version, $tfdString);
        $tfdString = str_replace('**UUID**', $tfd->UUID, $tfdString);
        $tfdString = str_replace('**FechaTimbrado**', $tfd->FechaTimbrado, $tfdString);
        $tfdString = str_replace('**RfcProvCertif**', $tfd->RfcProvCertif, $tfdString);
        $tfdString = str_replace('**SelloCFD**', $tfd->SelloCFD, $tfdString);
        $tfdString = str_replace('**NoCertificadoSAT**|', $tfd->NoCertificadoSAT, $tfdString);

        return $tfdString;
    }

    /**
     * Returns verification url given xml path
     * 
     * @param $xmlFile
     * @return string
     */
    public static function generateVerificationUrl($xmlFile)
    {
        $cfdiData = self::xmlToJson(file_get_contents($xmlFile));
        $verifyUrl = self::VERIFY_CFDI_URL;
        $verifyUrl = $verifyUrl . '?id=' . $cfdiData->Complemento->TimbreFiscalDigital->UUID;
        $verifyUrl = $verifyUrl . '&re=' . $cfdiData->Emisor->Rfc;
        $verifyUrl = $verifyUrl . '&rr=' . $cfdiData->Receptor->Rfc;
        $verifyUrl = $verifyUrl . '&tt=' . $cfdiData->Total;
        return $verifyUrl . '&fe=' . substr($cfdiData->Complemento->TimbreFiscalDigital->SelloCFD, -8);
    }
}
