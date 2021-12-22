<?php

namespace Lib\Cfdi40;



use Lib\Cfdi40\Impuestos40;
use Lib\Cfdi40\CuentaPredial40;
use Lib\Helper;

class Concepto40
{
    public $ClaveProdServ;
    public $ClaveUnidad;
    public $NoIdentificacion;
    public $Cantidad;
    public $Unidad;
    public $Descripcion;
    public $ValorUnitario;
    public $Descuento;
    public $Importe;
    public $Impuestos;
    public $CuentaPredial;
    public $ObjetoImp;
    // TODO:
    // Create class ACuentaTercetos40
    public $AcuentaTerceros;
    // Properties
    // RfcACuentaTerceros
    // NombreACuentaTerceros
    // RegimenFiscalACuentaTerceros
    // DomicilioFiscalACuentaTerceros
    // TODO:
    // Create class InformacionAduanera40
    public $InformacionAduanera;
    // Properties
    // NumeroPedimento

    public static function getConcepto($concepto)
    {
        try {

            $con = new Concepto40();
            $con->ClaveProdServ = Helper::getAttr('ClaveProdServ', $concepto);

            $con->ClaveUnidad = Helper::getAttr('ClaveUnidad', $concepto);
            $con->NoIdentificacion = Helper::getAttr('NoIdentificacion', $concepto);
            $con->Cantidad = Helper::getAttr('Cantidad', $concepto);
            $con->Unidad = Helper::getAttr('Unidad', $concepto);
            $con->Descripcion = Helper::getAttr('Descripcion', $concepto);
            $con->ValorUnitario = Helper::getAttr('ValorUnitario', $concepto);
            $con->Importe = Helper::getAttr('Importe', $concepto);
            $con->Impuestos = new Impuestos40();
            $con->Descuento = Helper::getAttr('Descuento', $concepto);
            $con->Impuestos = $con->Impuestos->getImpuestos($concepto, 0);
            $con->CuentaPredial = Helper::getAttr('cve_catastral', $concepto);
            $con->ObjetoImp = Helper::getAttr('ObjetoImp', $concepto);

            return $con;
        } catch (\Exception $e) {
            return null;
        }
    }
}
