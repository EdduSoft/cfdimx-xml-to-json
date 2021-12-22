<?php
namespace Lib\Tests;
require_once __DIR__ . "../../vendor/autoload.php";
use Lib\Cfdi33\Cfdi33;
use PHPUnit\Framework\TestCase;

class NominaTest extends TestCase {
    function testNominaObject() {
        echo "\n *---- Payroll object test ----* \n";
        $comp = Cfdi33::xmlToJson(file_get_contents("assets/33/nomina.xml"));
        echo json_encode($comp->Complemento->Nomina->NominaOtrosPagos);
        $this->assertNotNull($comp->Complemento->Nomina->NominaPercepciones33->Percepciones);
        $this->assertNotEmpty($comp->Complemento->Nomina->NominaDeducciones33->Deducciones);
    }
}