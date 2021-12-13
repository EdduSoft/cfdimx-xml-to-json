<?php 

namespace Lib\Cfdi40;

use Lib\Cfdi40\Comprobante40;

class Cfdi40 {

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
        try{
            libxml_use_internal_errors(true);
            $DocXML = new \DOMDocument('1.0', 'utf-8');
            $DocXML->preserveWhiteSpace = FALSE;
            $DocXML->loadXML($xmlString);
            $comprobante = self::getComprobante();

            return $comprobante->getObjectXML($DocXML);
        } catch(\Exception $e) {
            return null;
        }
    }
}