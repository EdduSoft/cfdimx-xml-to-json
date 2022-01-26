<?php

namespace Lib\Cfdi40;

use Lib\Helper;

class NominaPercepciones40
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

            $nominaPercepciones = $nomina->getElementsByTagName('Percepcion');
            foreach ($nominaPercepciones as $nominaPercepcion) {
                array_push(
                    $this->Percepciones,
                    new NominaPercepcion40($nominaPercepcion)
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