<?php

namespace Lib\Cfdi40;



use Lib\Cfdi40\TrasladoDR40;
use Lib\Cfdi40\RetencionDR40;

class ImpuestosDR40
{

    public $RetencionesDR;
    public $TrasladosDR;

    public static function getImpuestos($xml)
    {
        try {
            $obj = new ImpuestosDR40();
            $obj->TrasladosDR = array();
            $obj->RetencionesDR = array();
            if ($obj->getNode2($xml) != null) {
                $impuestos = $obj->getNode2($xml);
                $tras = $impuestos != null ? $obj->getTraslados($impuestos) : [];
                $ret  = $impuestos != null ? $obj->getRetenciones($impuestos) : [];


                foreach ($tras as $traslado) {
                    array_push($obj->TrasladosDR, TrasladoDR40::getTraslado($traslado));
                }
                foreach ($ret as $retencion) {
                    array_push($obj->RetencionesDR, RetencionDR40::getRetencion($retencion));
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
            return $xml->getElementsByTagName('ImpuestosDR')[0];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getNode1($xml)
    {
        try {
            $impuestos = $xml->getElementsByTagName('ImpuestosDR');
            return $impuestos[0];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getTraslados($impuestos)
    {
        try {
            return $impuestos->getElementsByTagName('TrasladoDR');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getRetenciones($impuestos)
    {
        try {
            return $impuestos->getElementsByTagName('RetencionDR');
        } catch (\Exception $e) {
            return null;
        }
    }
}
