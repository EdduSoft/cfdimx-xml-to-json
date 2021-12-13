<?php

namespace Lib\Cfdi33;


use Lib\Cfdi33\TimbreFiscalDigital33;

class Complemento33 
{
    
    public $TimbreFiscalDigital;
    public $Nomina;
    public $ComercioExterior;
    public $Pagos;
    public $ImpuestosLocales;
    
   
    
    public static function getComplemento($xml){
        try{
            $obj = new Complemento33();
            if($obj->getNode($xml) != null){
                $complemento = $obj->getNode($xml);
                $obj->TimbreFiscalDigital = new TimbreFiscalDigital33($complemento);
                $obj->Pagos = new Pagos33($complemento);
                //$obj->Nomina = new Nomina33($complemento);
                //$obj->ComercioExterior = new ComercioExterior33($complemento);
                //$obj->ImpuestosLocales = new ImpuestosLocales33($complememento);
                return $obj;

            }else{
                return null;
            }
        }
        catch(\Exception $e){
            return null;
        }
    }       
    
    public function getNode($xml){
        try{
            $complemento = $xml->getElementsByTagName('Complemento');
            return $complemento[0];
            
        }catch(\Exception $e){
            return null;
        } 
    }
}
