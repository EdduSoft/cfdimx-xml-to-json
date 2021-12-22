<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class NominaDeducciones33
{

    public string $TotalOtrasDeducciones = '';
    public string $TotalImpuestosRetenidos = '';
    public array $Deducciones = [];

    public function __construct($nomina)
    {
        try {
            $attributes = [
                'TotalOtrasDeducciones',
                'TotalImpuestosRetenidos',
            ];

            $deducciones = $this->getNode($nomina, 'Deducciones');
            foreach ($attributes as $attribute) {
                $this->$attribute = Helper::getAttr($attribute, $deducciones);
            }

            $nominaDeducciones = $nomina->getElementsByTagName('Deduccion');
            foreach ($nominaDeducciones as $nominaDeduccion) {
                array_push(
                    $this->Deducciones,
                    new NominaDeduccion33($nominaDeduccion)
                );
            }

            return $deducciones;
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