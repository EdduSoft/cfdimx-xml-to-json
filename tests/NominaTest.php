<?php
namespace Lib\Tests;
require_once __DIR__ . "../../vendor/autoload.php";
use Lib\Cfdi33\Cfdi33;
use PHPUnit\Framework\TestCase;

class NominaTest extends TestCase {
    function testNominaObject() {
        echo "\n *---- Payroll object test ----* \n";
        $comp = Cfdi33::xmlToJson(file_get_contents("assets/33/nomina.xml"));
        $nomina = $comp->Complemento->Nomina;
        
        // Payroll attributes
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
            'NominaEmisor33',
            'NominaReceptor33',
            'NominaPercepciones33',
            'NominaDeducciones33',
            'NominaOtrosPagos'
        ];
        
        foreach ($payrollAttributes as $attribute) {
            echo "\n -- Testing $attribute -- \n";
            $this->assertNotNull($nomina->$attribute);
        }
    }
}