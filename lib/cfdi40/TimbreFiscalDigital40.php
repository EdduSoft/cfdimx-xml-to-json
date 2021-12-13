<?php

namespace App\Cfdi40;

use Illuminate\Database\Eloquent\Model;

class TimbreFiscalDigital40
{
    public $Version;
    public $UUID;
    public $FechaTimbrado;
    public $RfcProvCertif;
    public $SelloCFD;
    public $NoCertificadoSAT;
    public $SelloSAT;
    
    
    
    
    public function __construct($comp){
        try{
            if($this->getNode($comp) != null){
                $complemento = $this->getNode($comp);                
                $this->Version = $complemento->getAttribute('Version');
                $this->UUID = $complemento->getAttribute('UUID');
                $this->FechaTimbrado = $complemento->getAttribute('FechaTimbrado');
                $this->RfcProvCertif = $complemento->getAttribute('RfcProvCertif');
                $this->SelloCFD = $complemento->getAttribute('SelloCFD');
                $this->NoCertificadoSAT = $complemento->getAttribute('NoCertificadoSAT');
                $this->SelloSAT = $complemento->getAttribute('SelloSAT');
                return $this;
            }else{
                return null;
            }
                
        }catch(\Exception $e){
            return null;
        }
    }
    
    public function getNode($complemento){
        try{
            $tim = $complemento->getElementsByTagName('TimbreFiscalDigital');
            return $tim[0];
        }catch(\Exception $e){
            return null;
        }
    }
}
