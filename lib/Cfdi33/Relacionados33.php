<?php

namespace Lib\Cfdi33;

use Lib\Cfdi33\Relacionado33;

use Lib\Helper;


class Relacionados33
{

    public $TipoRelacion;
    public $Relacionado;

    public static function getRelacionados($xml)
    {
        try {

            $obj = new Relacionados33();

            if ($obj->getNode($xml) != null && count($obj->getNode($xml)) > 0) {
                $relacionado = $obj->getNode($xml);
                if ($relacionado[0] != null) {
                    $obj->TipoRelacion = Helper::getAttr('TipoRelacion', $relacionado[0]);
                    $obj->Relacionado = Relacionado33::getRelacionados($relacionado);
                    return $obj;
                } else {
                    return null;
                }
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
            return $xml->getElementsByTagName('CfdiRelacionados');
        } catch (\Exception $e) {
            return null;
        }
    }
}
