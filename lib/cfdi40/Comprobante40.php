<?php

namespace App\Cfdi40;

use Illuminate\Database\Eloquent\Model;
use \DOMDocument;
use App\Cfdi40\Emisor40;
use App\Cfdi40\Receptor40;
use App\Cfdi40\Conceptos40;
use App\Cfdi40\Impuestos40;
use App\Cfdi40\Complemento40;
use App\Cfdi40\Relacionados40;

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
    //App\Relacionado33
    public $Relacionados;
    //App\Emisor33
    public $Emisor;
    //App\Receptor33
    public $Receptor;
    //App\Conceptos33
    public $Conceptos;
    //App\Impuestos33
    public $Impuestos;
    //App\Complemento33
    public $Complemento;
    
    
    
    public function getObjectXML($xml){
        try{
            if ($xml == null) return null;
            $obj = new Comprobante40();
            if($obj->getComprobante($xml) != null){
                $comprobante = $obj->getComprobante($xml);
                $obj = new Comprobante40();
                $obj->Version = $comprobante[0]->getAttribute('Version');
                $obj->Serie = $comprobante[0]->getAttribute('Serie');
                $obj->Folio = $comprobante[0]->getAttribute('Folio') == "" ? null : $comprobante[0]->getAttribute('Folio');
                $obj->Fecha = $comprobante[0]->getAttribute('Fecha');
                $obj->Sello = $comprobante[0]->getAttribute('Sello');
                $obj->NoCertificado = $comprobante[0]->getAttribute('NoCertificado');
                $obj->Certificado = $comprobante[0]->getAttribute('Certificado');
                $obj->SubTotal = $comprobante[0]->getAttribute('SubTotal');
                $obj->Moneda = $comprobante[0]->getAttribute('Moneda');
                $obj->Total = $comprobante[0]->getAttribute('Total');
                $obj->TipoDeComprobante = $comprobante[0]->getAttribute('TipoDeComprobante'); 
                $obj->FormaPago = $comprobante[0]->getAttribute('FormaPago');
                $obj->MetodoPago = $comprobante[0]->getAttribute('MetodoPago');
                $obj->CondicionesDePago = $comprobante[0]->getAttribute('CondicionesDePago');
                $obj->Descuento = $comprobante[0]->getAttribute('Descuento') == "" ? 0 : $comprobante[0]->getAttribute('Descuento');
                $obj->TipoCambio = $comprobante[0]->getAttribute('TipoCambio');
                $obj->LugarExpedicion = $comprobante[0]->getAttribute('LugarExpedicion');

                $obj->Emisor = Emisor40::getEmisor($xml);
                $obj->Receptor = Receptor40::getReceptor($xml);
                $obj->Conceptos = Conceptos40::getConceptos($xml);
                //$obj->Impuestos = Impuestos40::getImpuestos($xml, 1);
                $obj->Impuestos = $obj->TipoDeComprobante == 'P' ? null : Impuestos40::getImpuestos($xml, 1);
                $obj->Complemento = Complemento40::getComplemento($xml);
                $obj->Relacionados = Relacionados40::getRelacionados($xml);

        
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
            /*'Ocurrio un error al obtener los datos del comprobante'*/
        }        
    }
}
