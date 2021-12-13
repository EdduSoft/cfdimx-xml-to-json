<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class Emisor33 
{
    public $Rfc;
    public $Nombre;
    public $RegimenFiscal;
    public $Curp;
    
    public static function getEmisor($xml){
        $obj = new Emisor33();
        if($obj->getNode($xml) != null){
            $emisor = $obj->getNode($xml);
            $obj->Rfc = Helper::getAttr('Rfc', $emisor);
            $obj->Nombre = Helper::getAttr('Nombre', $emisor);
            $obj->RegimenFiscal = Helper::getAttr('RegimenFiscal', $emisor);
            $obj->Curp = Helper::getAttr('Curp', $emisor);
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
        } 
    }
}
