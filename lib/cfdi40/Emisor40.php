<?php

namespace App\Cfdi40;

use Illuminate\Database\Eloquent\Model;

class Emisor40
{
    public $Rfc;
    public $Nombre;
    public $RegimenFiscal;
    public $Curp;
    
    public static function getEmisor($xml){
        $obj = new Emisor40();
        if($obj->getNode($xml) != null){
            $emisor = $obj->getNode($xml);
            $obj->Rfc = $emisor->getAttribute('Rfc');
            $obj->Nombre = $emisor->getAttribute('Nombre');
            $obj->RegimenFiscal = $emisor->getAttribute('RegimenFiscal');
            $obj->Curp = $emisor->getAttribute('Curp');
            return $obj;
            
        }else{
            return null;
        } 
    }
    
    public function getNode($xml){
        try{
            $emisor = $xml->getElementsByTagName('Emisor');
            return $emisor[0]; 
        }catch(\Exception $e){
            return null;
            /*dd('Ocurrio un error al obtener los datos del Emisor', $e);*/
        } 
    }
}
