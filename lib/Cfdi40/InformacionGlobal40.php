<?php
namespace Lib\Cfdi40;

use Lib\Helper;

class InformacionGlobal40
{
    public string $Anio = '';
    public string $Meses = '';
    public string $Periodicidad = '';

    public static function getInformacionGlobal($comprobante)
    {
        try {
            $attributes = [
                'Meses',
                'Periodicidad'
            ];

            $infGlobal = new InformacionGlobal40();
            $informacionGlobal = $infGlobal->getNode($comprobante, 'InformacionGlobal');
            if ($informacionGlobal) {
                foreach ($attributes as $attribute) {
                    $infGlobal->$attribute = Helper::getAttr($attribute, $informacionGlobal);
                }
                
                $infGlobal->Anio = Helper::getAttr('Año', $informacionGlobal);
                return $infGlobal;
            } else {
                return null;
            }
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