<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class NominaReceptor33
{
    public string $Curp = '';
    public string $NumSeguridadSocial = '';
    public string $FechaInicioRelLaboral = '';
    public string $Antiguedad = '';
    public string $TipoContrato = '';
    public string $Sindicalizado = '';
    public string $TipoJornada = '';
    public string $TipoRegimen = '';
    public string $NumEmpleado = '';
    public string $Departamento = '';
    public string $Puesto = '';
    public string $RiesgoPuesto = '';
    public string $PeriodicidadPago = '';
    public string $SalarioBaseCotApor = '';
    public string $SalarioDiarioIntegrado = '';
    public string $ClaveEntFed = '';

    public function __construct($nomina)
    {
        try {
            $attributes = [
                'Curp',
                'NumSeguridadSocial',
                'FechaInicioRelLaboral',
                'Antiguedad',
                'TipoContrato',
                'Sindicalizado',
                'TipoJornada',
                'TipoRegimen',
                'NumEmpleado',
                'Departamento',
                'Puesto',
                'RiesgoPuesto',
                'PeriodicidadPago',
                'SalarioBaseCotApor',
                'SalarioDiarioIntegrado',
                'ClaveEntFed',
            ];

            $receptor = $this->getNode($nomina, 'Receptor');
            foreach ($attributes as $attribute) {
                $this->$attribute = Helper::getAttr($attribute, $receptor);
            }

            return $receptor;
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