<?php

namespace Lib\Cfdi33;


use \DOMDocument;
use Lib\Cfdi33\Emisor33;
use Lib\Cfdi33\Receptor33;
use Lib\Cfdi33\Conceptos33;
use Lib\Cfdi33\Impuestos33;
use Lib\Cfdi33\Complemento33;
use Lib\Cfdi33\Relacionados33;
use Lib\Helper;

class Comprobante33 
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
    //Lib\Cfdi33\Relacionado33
    public $Relacionados;
    //Lib\Cfdi33\Emisor33
    public $Emisor;
    //Lib\Cfdi33\Receptor33
    public $Receptor;
    //Lib\Cfdi33\Conceptos33
    public $Conceptos = [];
    //Lib\Cfdi33\Impuestos33
    public $Impuestos;
    //Lib\Cfdi33\Complemento33
    public $Complemento;
    
    
    
    public function getObjectXML($xml){
        try{
            if ($xml == null) return null;
            $obj = new Comprobante33();
            if($obj->getComprobante($xml) != null){
                $comprobante = $obj->getComprobante($xml);
                $obj = new Comprobante33();
                $obj->Version = Helper::getAttr('Version', $comprobante[0]);
                $obj->Serie = Helper::getAttr('Serie', $comprobante[0]);
                $obj->Folio = Helper::getAttr('Folio', $comprobante[0]) == "" ? null : Helper::getAttr('Folio', $comprobante[0]);
                $obj->Fecha = Helper::getAttr('Fecha', $comprobante[0]);
                $obj->Sello = Helper::getAttr('Sello', $comprobante[0]);
                $obj->NoCertificado = Helper::getAttr('NoCertificado', $comprobante[0]);
                $obj->Certificado = Helper::getAttr('Certificado', $comprobante[0]);
                $obj->SubTotal = Helper::getAttr('SubTotal', $comprobante[0]);
                $obj->Moneda = Helper::getAttr('Moneda', $comprobante[0]);
                $obj->Total = Helper::getAttr('Total', $comprobante[0]);
                $obj->TipoDeComprobante = Helper::getAttr('TipoDeComprobante', $comprobante[0]); 
                $obj->FormaPago = Helper::getAttr('FormaPago', $comprobante[0]);
                $obj->MetodoPago = Helper::getAttr('MetodoPago', $comprobante[0]);
                $obj->CondicionesDePago = Helper::getAttr('CondicionesDePago', $comprobante[0]);
                $obj->Descuento = Helper::getAttr('Descuento', $comprobante[0]) == "" ? 0 : Helper::getAttr('Descuento', $comprobante[0]);
                $obj->TipoCambio = Helper::getAttr('TipoCambio', $comprobante[0]);
                $obj->LugarExpedicion = Helper::getAttr('LugarExpedicion', $comprobante[0]);

                $obj->Emisor = Emisor33::getEmisor($xml);
                $obj->Receptor = Receptor33::getReceptor($xml);
                $obj->Conceptos = Conceptos33::getConceptos($xml);
                $obj->Impuestos = Impuestos33::getImpuestos($xml, 1);
                $obj->Impuestos = $obj->TipoDeComprobante == 'P' ? null : Impuestos33::getImpuestos($xml, 1);
                $obj->Complemento = Complemento33::getComplemento($xml);
                $obj->Relacionados = Relacionados33::getRelacionados($xml);

        
            }
            return $obj;
        }catch(\Exception $e){
            return null;
        }
    }
    
    public function getComprobante($xml){
        try{
            return $xml->getElementsByTagName('Comprobante');           
        }catch(\Exception $e){
            return null;
        }        
    }
}
