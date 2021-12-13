<?php

namespace App\Cfdi40;

use Illuminate\Database\Eloquent\Model;

use App\Cfdi40\Traslado40;
use App\Cfdi40\Retencion40;

class Impuestos40
{
    
    public $TotalImpuestosRetenidos;
    public $TotalImpuestosTrasladados;
    public $Retenciones;
    public $Traslados;
    
    public static function getImpuestos($xml, $flag){
        try{
            $obj = new Impuestos40();
            $obj->Traslados = array();
            $obj->Retenciones = array();
            if($obj->getNode1($xml) != null || $obj->getNode2($xml) != null){
                $impuestos = $flag == 0 ? $obj->getNode1($xml) : $obj->getNode2($xml);
                $obj->TotalImpuestosRetenidos = $impuestos != null ? $impuestos->getAttribute('TotalImpuestosRetenidos') : 0;
                $obj->TotalImpuestosTrasladados = $impuestos != null ? $impuestos->getAttribute('TotalImpuestosTrasladados') : 0;
                $tras = $impuestos != null ? $obj->getTraslados($impuestos) : [];
                $ret  = $impuestos != null ? $obj->getRetenciones($impuestos) : [];


                foreach($tras as $traslado){
                    array_push($obj->Traslados, Traslado40::getTraslado($traslado));
                }
                foreach($ret as $retencion){
                    array_push($obj->Retenciones, Retencion40::getRetencion($retencion));
                }
                return $obj;

            }else{
                return null;
            } 
            
        }catch(\Exception $e){
            return null;
        }
       
    }

    public function getNode2($xml){
        try{
            $compTemp = $xml;
            $comp = $compTemp->getElementsByTagName('Comprobante');
            if ($comp[0] != null) {
                foreach($comp[0]->getElementsByTagName('Conceptos') as $node ) {
                    $comp[0]->removeChild($node);
                }
                return $comp[0]->getElementsByTagName('Impuestos')[0];
            } else {
                return null;
            }
        }catch(\Exception $e){//dd($node);
            return null; 
        } 
    }       
    
    /* public function getNode2_OLD($xml){
        try{
            $impuestos = $xml->getElementsByTagName('Impuestos');
            $impuestos = $impuestos[$impuestos->length - 1];
            return $impuestos; 
        }catch(\Exception $e){
            return null;//dd('Ocurrio un error al obtener los impuestos', $e);
        } 
    } */
    
    public function getNode1($xml){
        try{
            $impuestos = $xml->getElementsByTagName('Impuestos');
            return $impuestos[0]; 
        }catch(\Exception $e){
            return null;// dd('Ocurrio un error al obtener los impuestos', $e);
        } 
    }
    
    public function getTraslados($impuestos){
        try{
            return $impuestos->getElementsByTagName('Traslado');
        }catch(\Exeption $e){
            return null;
        }
    }
    
    public function getRetenciones($impuestos){
        try{
            return $impuestos->getElementsByTagName('Retencion');
        }catch(\Exeption $e){
            return null;
        }
    }
    
    
}
