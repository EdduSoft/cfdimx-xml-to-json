<?php

namespace App\Cfdi40;

use Illuminate\Database\Eloquent\Model;

use App\Cfdi40\Impuestos40;
use App\Cfdi40\CuentaPredial40;

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
    
    public static function getConcepto($concepto){
        try{
            

            $con = new Concepto40();
            $con->ClaveProdServ = $concepto->getAttribute('ClaveProdServ');

            $con->ClaveUnidad = $concepto->getAttribute('ClaveUnidad');
            $con->NoIdentificacion = $concepto->getAttribute('NoIdentificacion');
            $con->Cantidad = $concepto->getAttribute('Cantidad');
            $con->Unidad = $concepto->getAttribute('Unidad');
            $con->Descripcion = $concepto->getAttribute('Descripcion');
            $con->ValorUnitario = $concepto->getAttribute('ValorUnitario');
            $con->Importe = $concepto->getAttribute('Importe');
            $con->Impuestos = new Impuestos40();
            $con->Descuento = $concepto->getAttribute('Descuento');
            $con->Impuestos = $con->Impuestos->getImpuestos($concepto, 0);
            $con->CuentaPredial = $concepto->getAttribute('cve_catastral');

            return $con;

            
        }catch(\Exeption $e){
            //dd($e);
            return null;
            /*Ocurrio un error al obtener los atributos del concepto*/
        }
    }
    

}
