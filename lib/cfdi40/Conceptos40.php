<?php

namespace Lib\Cfdi40;



use Lib\Cfdi40\Concepto40;

class Conceptos40
{
    public $Conceptos;
    
    public static function getConceptos($xml){
        $obj = new Conceptos40();
        $obj->Conceptos = array();
        
        if($obj->getNode($xml) != null){
            $concep = $obj->getNode($xml);
            foreach($concep as $concepto){
                array_push($obj->Conceptos, Concepto40::getConcepto($concepto));
            }
            return $obj;

        }else{
            return null;
        } 
    }       
    
    public function getNode($xml){
        try{
            return $xml->getElementsByTagName('Concepto');
        }catch(\Exception $e){
            return null;
            
        } 
    }
}
