<?php
namespace Lib\Tests;
require_once __DIR__ . "../../vendor/autoload.php";
use Lib\Cfdi40\Cfdi40;
use PHPUnit\Framework\TestCase;

class InformacionGlobalTest extends TestCase {
    function testInformacionGlobalObject() {
        $files = [
            'assets/40/facturacion_normal.xml',
            'assets/40/infoGlobal.xml'
        ];

        // Payroll attributes
        $attributes = [
            'Anio',
            'Meses',
            'Periodicidad',
        ];

        echo "\n *---- Global information object test ----* \n";

        foreach ($files as $file) {

            echo "\n *---- File: $file ----* \n";

            $comp = Cfdi40::xmlToJson(file_get_contents($file));
            $globalInformation = $comp->InformacionGlobal40;

            foreach ($attributes as $attribute) {
                echo "\n -- Testing $attribute -- \n";
                $value = $globalInformation->$attribute;
                $this->assertNotNull($value);
            }
        }
    }
}