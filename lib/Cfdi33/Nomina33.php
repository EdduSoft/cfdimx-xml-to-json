<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class Nomina33
{
    public string $Version = '';
    public string $TipoNomina = '';
    public string $FechaPago = '';
    public string $FechaInicialPago = '';
    public string $FechaFinalPago = '';
    public string $NumDiasPagados = '';
    public string $TotalPercepciones = '';
    public string $TotalDeducciones = '';
    public string $TotalOtrosPagos = '';
    
    public NominaEmisor33 $NominaEmisor33;
    public NominaReceptor33 $NominaReceptor33;

    public function __construct($comp)
    {
        try {
            $payrollAttributes = [
                'Version',
                'TipoNomina',
                'FechaPago',
                'FechaInicialPago',
                'FechaFinalPago',
                'NumDiasPagados',
                'TotalPercepciones',
                'TotalDeducciones',
                'TotalOtrosPagos',
            ];

            // Nomina node
            $nomina = $this->getNode($comp, 'Nomina');
            foreach ($payrollAttributes as $attribute) {
                $this->$attribute = Helper::getAttr($attribute, $nomina);
            }
            
            // Emisor node
            $this->NominaEmisor33 = new NominaEmisor33($nomina);
            
            // Receptor node
            $this->NominaReceptor33 = new NominaReceptor33($nomina);
            
            return $nomina;
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