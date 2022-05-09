<?php
namespace Lib\Tests;
require_once __DIR__ . "../../vendor/autoload.php";
use Lib\Cfdi33\Cfdi33;
use Lib\Cfdi40\Cfdi40;
use PHPUnit\Framework\TestCase;

class NominaTest extends TestCase {
    function testNominaObject() {
        $payrollFiles = [
            'assets/33/nomina.xml',
            'assets/33/nomina2.xml',
            'assets/33/nomina3.xml'
        ];
        
        $payrollFilesV4 = [
            'assets/40/nomina.xml'
        ];

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
            'Emisor',
            'Receptor',
            'Percepciones',
            'Deducciones',
            'OtrosPagos'
        ];
        
        echo "\n *---- Payroll object test ----* \n";
        
        foreach ($payrollFiles as $payrollFile) {

            echo "\n *---- File: $payrollFile ----* \n";

            $comp = Cfdi33::xmlToJson(file_get_contents($payrollFile));
            $nomina = $comp->Complemento->Nomina;

            foreach ($payrollAttributes as $attribute) {
                echo "\n -- Testing $attribute -- \n";
                $value = $nomina->$attribute;
                echo "\n " . json_encode($value) . " \n";
                $this->assertNotNull($value);
            }   
        }

        echo "\n *---- Payroll V4 object test ----* \n";

        foreach ($payrollFilesV4 as $payrollFile) {

            echo "\n *---- File: $payrollFile ----* \n";

            $comp = Cfdi40::xmlToJson(file_get_contents($payrollFile));
            $nomina = $comp->Complemento->Nomina;

            foreach ($payrollAttributes as $attribute) {
                echo "\n -- Testing $attribute -- \n";
                $value = $nomina->$attribute;
                echo "\n " . json_encode($value) . " \n";
                $this->assertNotNull($value);
            }
        }
    }
}