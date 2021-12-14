<?php

namespace Lib\Cfdi40;


use \DOMDocument;
use Lib\Cfdi40\Emisor40;
use Lib\Cfdi40\Receptor40;
use Lib\Cfdi40\Conceptos40;
use Lib\Cfdi40\Impuestos40;
use Lib\Cfdi40\Complemento40;
use Lib\Cfdi40\Relacionados40;

use Lib\Helper;

class Comprobante40
{
    //Comprobante
    public  $Version;
    public  $Serie;
    public  $Folio;
    public  $Fecha;
    public  $Sello;
    public  $NoCertificado;
    public  $Certificado;
    public  $SubTotal;
    public  $Moneda;
    public  $Total;
    public  $TipoDeComprobante;
    public  $FormaPago;
    public  $MetodoPago;
    public  $CondicionesDePago;
    public  $Descuento;
    public  $TipoCambio;
    public  $LugarExpedicion;
    //Lib\Cfdi40\Relacionado40
    public $Relacionados;
    //Lib\Cfdi40\Emisor40
    public ?Emisor40 $Emisor;
    //Lib\Cfdi40\Receptor40
    public ?Receptor40 $Receptor;
    //Lib\Cfdi40\Conceptos40
    public $Conceptos;
    //Lib\Cfdi40\Impuestos40
    public ?Impuestos40 $Impuestos;
    //Lib\Cfdi40\Complemento40
    public ?Complemento40 $Complemento;



    public function getObjectXML($xml)
    {
        try {
            if ($xml == null) return null;
            $obj = new Comprobante40();
            if ($obj->getComprobante($xml) != null) {
                $comprobante = $obj->getComprobante($xml);
                $obj = new Comprobante40();
                $obj->Version = Helper::getAttr('Version',  $comprobante[0]);
                $obj->Serie = Helper::getAttr('Serie',  $comprobante[0]);
                $obj->Folio = Helper::getAttr('Folio',  $comprobante[0]) == "" ? null : Helper::getAttr('Folio',  $comprobante[0]);
                $obj->Fecha = Helper::getAttr('Fecha',  $comprobante[0]);
                $obj->Sello = Helper::getAttr('Sello',  $comprobante[0]);
                $obj->NoCertificado = Helper::getAttr('NoCertificado',  $comprobante[0]);
                $obj->Certificado = Helper::getAttr('Certificado',  $comprobante[0]);
                $obj->SubTotal = Helper::getAttr('SubTotal',  $comprobante[0]);
                $obj->Moneda = Helper::getAttr('Moneda',  $comprobante[0]);
                $obj->Total = Helper::getAttr('Total',  $comprobante[0]);
                $obj->TipoDeComprobante = Helper::getAttr('TipoDeComprobante',  $comprobante[0]);
                $obj->FormaPago = Helper::getAttr('FormaPago',  $comprobante[0]);
                $obj->MetodoPago = Helper::getAttr('MetodoPago',  $comprobante[0]);
                $obj->CondicionesDePago = Helper::getAttr('CondicionesDePago',  $comprobante[0]);
                $obj->Descuento = Helper::getAttr('Descuento',  $comprobante[0]) == "" ? 0 : Helper::getAttr('Descuento',  $comprobante[0]);
                $obj->TipoCambio = Helper::getAttr('TipoCambio',  $comprobante[0]);
                $obj->LugarExpedicion = Helper::getAttr('LugarExpedicion',  $comprobante[0]);

                $obj->Emisor = Emisor40::getEmisor($xml);
                $obj->Receptor = Receptor40::getReceptor($xml);
                $obj->Conceptos = Conceptos40::getConceptos($xml);
                $obj->Impuestos = Impuestos40::getImpuestos($xml, 1);
                $obj->Impuestos = $obj->TipoDeComprobante == 'P' ? null : Impuestos40::getImpuestos($xml, 1);
                $obj->Complemento = Complemento40::getComplemento($xml);
                $obj->Relacionados = Relacionados40::getRelacionados($xml);
            }
            return $obj;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getComprobante($xml)
    {
        try {
            return $xml->getElementsByTagName('Comprobante');
        } catch (\Exception $e) {
            return null;
        }
    }
}
