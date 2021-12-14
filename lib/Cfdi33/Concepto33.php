<?php

namespace Lib\Cfdi33;



use Lib\Cfdi33\Impuestos33;
use Lib\Cfdi33\CuentaPredial33;
use Lib\Helper;

class Concepto33
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
    public ?Impuestos33 $Impuestos;
    public $CuentaPredial;

    public static function getConcepto($concepto)
    {
        try {


            $con = new Concepto33();
            $con->ClaveProdServ = Helper::getAttr('ClaveProdServ', $concepto);

            $con->ClaveUnidad = Helper::getAttr('ClaveUnidad', $concepto);
            $con->NoIdentificacion = Helper::getAttr('NoIdentificacion', $concepto);
            $con->Cantidad = Helper::getAttr('Cantidad', $concepto);
            $con->Unidad = Helper::getAttr('Unidad', $concepto);
            $con->Descripcion = Helper::getAttr('Descripcion', $concepto);
            $con->ValorUnitario = Helper::getAttr('ValorUnitario', $concepto);
            $con->Importe = Helper::getAttr('Importe', $concepto);
            $con->Impuestos = new Impuestos33();
            $con->Descuento = Helper::getAttr('Descuento', $concepto);
            $con->Impuestos = $con->Impuestos->getImpuestos($concepto, 0);
            $con->CuentaPredial = Helper::getAttr('cve_catastral', $concepto);

            return $con;
        } catch (\Exception $e) {
            return null;
        }
    }
}
