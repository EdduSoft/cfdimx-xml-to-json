<?php

namespace App\Cfdi40;

use Illuminate\Database\Eloquent\Model;

class Receptor40
{
    public $Rfc;
    public $Nombre;
    public $UsoCFDI;
    public $Curp;
    public $Domicilio;
    public $DomicilioFiscalReceptor;
    public $RegimenFiscalReceptor;

    
    public static function getReceptor($xml){
        $obj = new Receptor40();
        if($obj->getNode($xml) != null){
            $receptor = $obj->getNode($xml);
            $obj->Rfc = $receptor->getAttribute('Rfc');
            $obj->Nombre = $receptor->getAttribute('Nombre');
            $obj->UsoCFDI = $receptor->getAttribute('UsoCFDI');
            $obj->Curp = $receptor->getAttribute('Curp');
            $obj->RegimenFiscalReceptor = $receptor->getAttribute('RegimenFiscalReceptor');
            $obj->DomicilioFiscalReceptor = $receptor->getAttribute('DomicilioFiscalReceptor');

            return $obj;
            
        }else{
            return null;
        } 
    }
    
    public function getNode($xml){
        try{
            $receptor = $xml->getElementsByTagName('Receptor');
            return $receptor[0]; 
        }catch(\Exception $e){
            return null;
            /*dd('Ocurrio un error al obtener los datos del Emisor', $e);*/
        } 
    }
}
