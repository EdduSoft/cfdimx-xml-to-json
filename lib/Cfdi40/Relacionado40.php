<?php

namespace Lib\Cfdi40;

use Lib\Helper;

class Relacionado40
{

    public $UUID;

    public static function getRelacionados($relacionado)
    {
        try {
            $obj = new Relacionado40();
            $relacionadosArray = array();

            if ($obj->getNode($relacionado) != null) {
                $relacionados = $obj->getNode($relacionado);
                foreach ($relacionados as $relacion) {
                    $rela = new Relacionado40();
                    $rela->UUID = Helper::getAttr('UUID', $relacion);
                    array_push($relacionadosArray, $rela);
                }
                return $relacionadosArray;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getNode($xml)
    {
        try {
            return $xml[0]->getElementsByTagName('CfdiRelacionado');
        } catch (\Exception $e) {
            return null;
        }
    }
}
