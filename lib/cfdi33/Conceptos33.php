<?php

namespace Lib\Cfdi33;



use Lib\Cfdi33\Concepto33;

class Conceptos33
{
    public $Conceptos = [];
    
    public static function getConceptos($xml){
        $obj = new Conceptos33();
        $obj->Conceptos = array();
        
        if($obj->getNode($xml) != null){
            $concep = $obj->getNode($xml);
            foreach($concep as $concepto) {
                array_push($obj->Conceptos, Concepto33::getConcepto($concepto));
            }
            return $obj->Conceptos;

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
