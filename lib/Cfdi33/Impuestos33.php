<?php

namespace Lib\Cfdi33;



use Lib\Cfdi33\Traslado33;
use Lib\Cfdi33\Retencion33;

use Lib\Helper;

class Impuestos33
{

    public $TotalImpuestosRetenidos;
    public $TotalImpuestosTrasladados;
    public ?array $Retenciones;
    public ?array $Traslados;

    public static function getImpuestos($xml, $flag)
    {
        try {
            $obj = new Impuestos33();
            $obj->Traslados = array();
            $obj->Retenciones = array();
            if ($obj->getNode1($xml) != null || $obj->getNode2($xml) != null) {
                $impuestos = $flag == 0 ? $obj->getNode1($xml) : $obj->getNode2($xml);
                $obj->TotalImpuestosRetenidos = $impuestos != null ? Helper::getAttr('TotalImpuestosRetenidos', $impuestos) : 0;
                $obj->TotalImpuestosTrasladados = $impuestos != null ? Helper::getAttr('TotalImpuestosTrasladados', $impuestos) : 0;
                $tras = $impuestos != null ? $obj->getTraslados($impuestos) : [];
                $ret  = $impuestos != null ? $obj->getRetenciones($impuestos) : [];


                foreach ($tras as $traslado) {
                    array_push($obj->Traslados, Traslado33::getTraslado($traslado));
                }
                foreach ($ret as $retencion) {
                    array_push($obj->Retenciones, Retencion33::getRetencion($retencion));
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
            $compTemp = $xml;
            $comp = $compTemp->getElementsByTagName('Comprobante');
            if ($comp[0] != null) {
                foreach ($comp[0]->getElementsByTagName('Conceptos') as $node) {
                    $comp[0]->removeChild($node);
                }
                return $comp[0]->getElementsByTagName('Impuestos')[0];
            } else {
                return null;
            }
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
            return $impuestos->getElementsByTagName('Traslado');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getRetenciones($impuestos)
    {
        try {
            return $impuestos->getElementsByTagName('Retencion');
        } catch (\Exception $e) {
            return null;
        }
    }
}
