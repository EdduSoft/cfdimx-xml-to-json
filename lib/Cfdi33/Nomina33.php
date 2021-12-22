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
    
    public NominaEmisor33 $Emisor;
    public NominaReceptor33 $Receptor;
    public NominaPercepciones33 $Percepciones;
    public NominaDeducciones33 $Deducciones;
    
    public array $OtrosPagos = [];

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
            
            if (!$nomina) return null;
            
            foreach ($payrollAttributes as $attribute) {
                $this->$attribute = Helper::getAttr($attribute, $nomina);
            }
            
            // Emisor node
            $this->Emisor = new NominaEmisor33($nomina);
            
            // Receptor node
            $this->Receptor = new NominaReceptor33($nomina);
            
            // Percepciones node
            $this->Percepciones = new NominaPercepciones33($nomina);
            
            // Deducciones node
            $this->Deducciones = new NominaDeducciones33($nomina);
            
            // Otros pagos node
            $nominaOtrosPagos = $nomina->getElementsByTagName('OtroPago');
            foreach ($nominaOtrosPagos as $nominaOtroPago) {
                array_push(
                    $this->OtrosPagos,
                    new NominaOtroPago33($nominaOtroPago)
                );
            }
            
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