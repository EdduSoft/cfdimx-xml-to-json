<?php

namespace Lib\Cfdi40;

use Lib\Cfdi40\Relacionado40;

use Lib\Helper;

class Relacionados40
{

    public $TipoRelacion;
    public $Relacionado;

    public static function getRelacionados($xml)
    {
        try {

            $obj = new Relacionados40();

            if ($obj->getNode($xml) != null && count($obj->getNode($xml)) > 0) {
                $relacionado = $obj->getNode($xml);
                if ($relacionado[0] != null) {
                    $obj->TipoRelacion = Helper::getAttr('TipoRelacion', $relacionado[0]);
                    $obj->Relacionado = Relacionado40::getRelacionados($relacionado);
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
