<?php

namespace App\Test;

require_once __DIR__ . "../../vendor/autoload.php";
use PHPUnit\Framework\TestCase;

use Lib\Cfdi33\Cfdi33;
use Lib\Cfdi33\Xml33;
use Lib\Cfdi40\Cfdi40;

class CadenaOriginalTest extends TestCase
{
    const FILES_TO_TEST = [
        "assets/33/facturacion_normal.xml",
        "assets/33/complemento_pago.xml",
        "assets/33/nota_credito.xml",
        "assets/33/sustitucion.xml"
    ];
    
    public function testTfdOriginalString()
    {
        echo "\n *------ Testing tfd original string ------* \n";
        foreach (self::FILES_TO_TEST as $file) {
            $result = Cfdi33::xmlToJson(file_get_contents($file))
                ->Complemento
                ->TimbreFiscalDigital
                ->CadenaOriginalTfd;
            
            echo "------ File: $file ------ \n";
            echo json_encode($result, JSON_PRETTY_PRINT) . "\n";
            $this->assertNotNull($result);    
        }
    }

    public function testVerifyUrl()
    {
        echo "\n *------ Testing verify URL ------* \n";
        foreach (self::FILES_TO_TEST as $file) {
            $result = Cfdi33::xmlToJson(file_get_contents($file))->VerificacionUrl;
            echo "------ File: $file ------ \n";
            echo json_encode($result, JSON_PRETTY_PRINT) . "\n";
            $this->assertNotNull($result);
        }
    }
}