<?php

namespace Lib\Cfdi40;

use Lib\Helper;

class NominaEmisor40
{
    public string $RegistroPatronal = '';

    public function __construct($nomina)
    {
        try {
            $attributes = [
                'RegistroPatronal',
            ];

            $emisor = $this->getNode($nomina, 'Emisor');
            foreach ($attributes as $attribute) {
                if ($emisor) {
                    $this->$attribute = Helper::getAttr($attribute, $emisor);
                }
            }

            return $emisor;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getNode($complemento, $nodo)
    {
        try {
            $pag = $complemento->getElementsByTagName($nodo);
            return $pag[0];
        } catch (\Exception $e) {
            return null;
        }
    }
}