<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class Receptor33
{
    public $Rfc;
    public $Nombre;
    public $UsoCFDI;
    public $Curp;
    public $Domicilio;

    
    public static function getReceptor($xml){
        $obj = new Receptor33();
        if($obj->getNode($xml) != null){
            $receptor = $obj->getNode($xml);
            $obj->Rfc = Helper::getAttr('Rfc', $receptor);
            $obj->Nombre = Helper::getAttr('Nombre', $receptor);
            $obj->UsoCFDI = Helper::getAttr('UsoCFDI', $receptor);
            $obj->Curp = Helper::getAttr('Curp', $receptor);
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
        } 
    }
}
