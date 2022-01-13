<?php
namespace Lib\Cfdi40;

use Lib\Helper;

class InformacionGlobal40
{
    public string $Anio = '';
    public string $Meses = '';
    public string $Periodicidad = '';

    public function __construct($comprobante)
    {
        try {
            $attributes = [
                'Meses',
                'Periodicidad'
            ];

            $informacionGlobal = $this->getNode($comprobante, 'InformacionGlobal');
            foreach ($attributes as $attribute) {
                if ($informacionGlobal) {
                    $this->$attribute = Helper::getAttr($attribute, $informacionGlobal);
                }
            }

            if ($informacionGlobal) {
                $this->Anio = Helper::getAttr('Año', $informacionGlobal);
            }
            
            return $informacionGlobal;
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