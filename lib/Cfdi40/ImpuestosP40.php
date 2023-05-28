<?php

namespace Lib\Cfdi40;



use Lib\Cfdi40\TrasladoP40;
use Lib\Cfdi40\RetencionP40;

class ImpuestosP40
{

    public $RetencionesP;
    public $TrasladosP;

    public static function getImpuestos($xml)
    {
        try {
            $obj = new ImpuestosP40();
            $obj->TrasladosP = array();
            $obj->RetencionesP = array();
            if ($obj->getNode1($xml) != null || $obj->getNode2($xml) != null) {
                $impuestos = $obj->getNode2($xml);
                $tras = $impuestos != null ? $obj->getTraslados($impuestos) : [];
                $ret  = $impuestos != null ? $obj->getRetenciones($impuestos) : [];


                foreach ($tras as $traslado) {
                    array_push($obj->TrasladosP, TrasladoP40::getTraslado($traslado));
                }
                foreach ($ret as $retencion) {
                    array_push($obj->RetencionesP, RetencionP40::getRetencion($retencion));
                }
                return $obj;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getNode2($xml)
    {
        try {
            return $xml->getElementsByTagName('ImpuestosP')[0];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getNode1($xml)
    {
        try {
            $impuestos = $xml->getElementsByTagName('Impuestos');
            return $impuestos[0];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getTraslados($impuestos)
    {
        try {
            return $impuestos->getElementsByTagName('TrasladoP');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getRetenciones($impuestos)
    {
        try {
            return $impuestos->getElementsByTagName('RetencionP');
        } catch (\Exception $e) {
            return null;
        }
    }
}
