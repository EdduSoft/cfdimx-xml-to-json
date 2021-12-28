<?php

namespace Lib;

class Helper
{

    const VERSION_32 = '3.2';
    const VERSION_33 = '3.3';
    const VERSION_40 = '4.0';

    /**
     * Get attribute from node element
     *
     * @param [type] $elem
     * @param [type] $attr
     * @return String
     */
    public static function getAttr($attr, $elem)
    {
        try {
            return $elem->getAttribute($attr);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get cfdi version
     *
     * @param [type] $xml
     * @return string
     */
    public static function identifyVersion($dom) : string
    {
        try {
            $comprobante = $dom->getElementsByTagName('Comprobante');
            return $comprobante[0]->getAttribute('Version');
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Validate if the cfdi is version 3.3
     *
     * @param [type] $version
     * @return boolean
     */
    public static function isVersion32($version) : bool
    {
        try {
            return $version == self::VERSION_32 ? true : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate if the cfdi is version 3.3
     *
     * @param [type] $version
     * @return boolean
     */
    public static function isVersion33($version) : bool
    {
        try {
            return $version == self::VERSION_33 ? true : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate if the cfdi is version 4.0
     *
     * @param [type] $version
     * @return boolean
     */
    public static function isVersion40($version) : bool
    {
        try {
            return $version == self::VERSION_40 ? true : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get DomDocument from XmlString
     *
     * @param string $xmlString
     * @return \DOMDocument
     */
    public static function getDomDocument(string $xmlString): \DOMDocument
    {
        try {
            libxml_use_internal_errors(true);
            $DocXML = new \DOMDocument('1.0', 'utf-8');
            $DocXML->preserveWhiteSpace = FALSE;
            $DocXML->loadXML($xmlString);
            return $DocXML;
        } catch (\Exception $e) {
            return null;
        }
    }
}
