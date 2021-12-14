<?php

namespace Lib\Cfdi33;

use Lib\Cfdi33\Comprobante33;

class Cfdi33
{

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
}
