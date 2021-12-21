<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class NominaPercepciones33
{

    public string $TotalSueldos = '';
    public string $TotalGravado = '';
    public string $TotalExento = '';
    public array $Percepciones = [];

    public function __construct($nomina)
    {
        try {
            $attributes = [
                'TotalSueldos',
                'TotalGravado',
                'TotalExento'
            ];

            $percepciones = $this->getNode($nomina, 'Percepciones');
            foreach ($attributes as $attribute) {
                $this->$attribute = Helper::getAttr($attribute, $percepciones);
            }
            
            $nominaPercepciones = $this->getNode($percepciones, 'Percepcion');
            foreach ($nominaPercepciones as $nominaPercepcion) {
                array_push(
                    $this->Percepciones,
                    NominaPercepcion33::getPercepcion($nominaPercepcion)
                );
            }

            return $percepciones;
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